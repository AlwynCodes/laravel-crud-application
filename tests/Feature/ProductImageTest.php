<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductImageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    public function test_administrator_can_upload_an_image(): void
    {
        $this->actingAs($this->admin())
            ->post(route('product.store'), [
                'name' => 'Product With Image',
                'qty' => 8,
                'price' => 1999.00,
                'image' => UploadedFile::fake()->image('headphones.png', 800, 600),
            ])
            ->assertRedirect(route('product.index'));

        $product = Product::query()->where('name', 'Product With Image')->firstOrFail();

        $this->assertNotNull($product->image_path);
        $this->assertStringStartsWith('products/', $product->image_path);
        Storage::disk('public')->assertExists($product->image_path);

        $this->actingAs($this->admin())
            ->get(route('product.show', ['product' => $product]))
            ->assertOk()
            ->assertSee($product->image_path);
    }

    public function test_products_without_an_image_can_still_be_created(): void
    {
        $this->actingAs($this->admin())
            ->post(route('product.store'), [
                'name' => 'No Image Product',
                'qty' => 2,
                'price' => 99,
            ])
            ->assertRedirect(route('product.index'));

        $this->assertDatabaseHas('products', [
            'name' => 'No Image Product',
            'image_path' => null,
        ]);
    }

    public function test_php_file_disguised_as_an_image_is_rejected(): void
    {
        $this->actingAs($this->admin())
            ->post(route('product.store'), [
                'name' => 'Malicious Upload',
                'qty' => 1,
                'price' => 10,
                'image' => $this->uploadWithContent('malicious.php.jpg', '<?php echo "pwned"; ?>'),
            ])
            ->assertSessionHasErrors('image');

        $this->assertDatabaseMissing('products', ['name' => 'Malicious Upload']);
        $this->assertCount(0, Storage::disk('public')->files('products'));
    }

    public function test_unsupported_file_type_is_rejected(): void
    {
        $this->actingAs($this->admin())
            ->post(route('product.store'), [
                'name' => 'Gif Upload',
                'qty' => 1,
                'price' => 10,
                'image' => UploadedFile::fake()->image('animation.gif', 400, 400),
            ])
            ->assertSessionHasErrors('image');

        $this->assertDatabaseCount('products', 0);
    }

    public function test_images_larger_than_two_megabytes_are_rejected(): void
    {
        $this->actingAs($this->admin())
            ->post(route('product.store'), [
                'name' => 'Oversized Upload',
                'qty' => 1,
                'price' => 10,
                'image' => UploadedFile::fake()->image('huge.png')->size(3000),
            ])
            ->assertSessionHasErrors('image');

        $this->assertDatabaseCount('products', 0);
    }

    public function test_replacing_an_image_deletes_the_previous_file(): void
    {
        $product = Product::factory()->withImage('products/old-image.png')->create();
        Storage::disk('public')->put('products/old-image.png', 'old');

        $this->actingAs($this->admin())
            ->put(route('product.update', ['product' => $product]), [
                'name' => $product->name,
                'qty' => $product->qty,
                'price' => $product->price,
                'image' => UploadedFile::fake()->image('new-image.png'),
            ])
            ->assertRedirect(route('product.index'));

        $product->refresh();

        Storage::disk('public')->assertMissing('products/old-image.png');
        Storage::disk('public')->assertExists($product->image_path);
        $this->assertNotSame('products/old-image.png', $product->image_path);
    }

    public function test_a_failed_replacement_keeps_the_existing_image_and_data(): void
    {
        $product = Product::factory()->withImage('products/keep-image.png')->create([
            'name' => 'Unchanged Product',
        ]);
        Storage::disk('public')->put('products/keep-image.png', 'keep');

        $this->actingAs($this->admin())
            ->put(route('product.update', ['product' => $product]), [
                'name' => 'Renamed Product',
                'qty' => 99,
                'price' => 12345,
                'image' => $this->uploadWithContent('malicious.php.jpg', '<?php ?>'),
            ])
            ->assertSessionHasErrors('image');

        Storage::disk('public')->assertExists('products/keep-image.png');

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Unchanged Product',
            'image_path' => 'products/keep-image.png',
        ]);
    }

    public function test_deleting_a_product_removes_its_image(): void
    {
        $product = Product::factory()->withImage('products/delete-me.png')->create();
        Storage::disk('public')->put('products/delete-me.png', 'image');

        $this->actingAs($this->admin())
            ->delete(route('product.destroy', ['product' => $product]))
            ->assertRedirect(route('product.index'));

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
        Storage::disk('public')->assertMissing('products/delete-me.png');
    }

    public function test_deleting_a_product_without_an_image_is_allowed(): void
    {
        $product = Product::factory()->create();

        $this->actingAs($this->admin())
            ->delete(route('product.destroy', ['product' => $product]))
            ->assertRedirect(route('product.index'));

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    private function admin(): User
    {
        return User::factory()->admin()->create();
    }

    /**
     * Build a genuine upload whose bytes are not an image.
     *
     * UploadedFile::fake() guesses the MIME type from the file name, so a real
     * temporary file is needed to prove the server inspects the contents.
     */
    private function uploadWithContent(string $name, string $content): UploadedFile
    {
        $path = tempnam(sys_get_temp_dir(), 'lab4-upload-');
        file_put_contents($path, $content);

        return new UploadedFile($path, $name, 'image/jpeg', null, true);
    }
}
