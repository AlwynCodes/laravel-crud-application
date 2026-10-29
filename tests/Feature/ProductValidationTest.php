<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_login(): void
    {
        $this->get(route('product.index'))->assertRedirect(route('login'));
        $this->post(route('product.store'), [])->assertRedirect(route('login'));
    }

    public function test_empty_form_is_rejected_with_validation_errors(): void
    {
        $this->actingAs($this->admin())
            ->post(route('product.store'), [])
            ->assertSessionHasErrors(['name', 'qty', 'price']);

        $this->assertDatabaseCount('products', 0);
    }

    public function test_negative_price_is_rejected(): void
    {
        $this->actingAs($this->admin())
            ->post(route('product.store'), [
                'name' => 'Negative Price Product',
                'qty' => 5,
                'price' => -500,
            ])
            ->assertSessionHasErrors('price');

        $this->assertDatabaseMissing('products', ['name' => 'Negative Price Product']);
    }

    public function test_fractional_and_negative_quantities_are_rejected(): void
    {
        $this->actingAs($this->admin())
            ->post(route('product.store'), [
                'name' => 'Fractional Quantity',
                'qty' => 2.5,
                'price' => 100,
            ])
            ->assertSessionHasErrors('qty');

        $this->actingAs($this->admin())
            ->post(route('product.store'), [
                'name' => 'Negative Quantity',
                'qty' => -3,
                'price' => 100,
            ])
            ->assertSessionHasErrors('qty');

        $this->assertDatabaseCount('products', 0);
    }

    public function test_name_longer_than_255_characters_is_rejected(): void
    {
        $this->actingAs($this->admin())
            ->post(route('product.store'), [
                'name' => str_repeat('a', 256),
                'qty' => 1,
                'price' => 100,
            ])
            ->assertSessionHasErrors('name');

        $this->assertDatabaseCount('products', 0);
    }

    public function test_price_with_more_than_two_decimal_places_is_rejected(): void
    {
        $this->actingAs($this->admin())
            ->post(route('product.store'), [
                'name' => 'Too Many Decimals',
                'qty' => 1,
                'price' => 10.999,
            ])
            ->assertSessionHasErrors('price');

        $this->assertDatabaseCount('products', 0);
    }

    public function test_valid_product_is_created(): void
    {
        $this->actingAs($this->admin())
            ->post(route('product.store'), [
                'name' => 'Aqua Flask Tumbler',
                'description' => 'Insulated 1L stainless steel tumbler.',
                'qty' => 24,
                'price' => 549.00,
            ])
            ->assertRedirect(route('product.index'));

        $this->assertDatabaseHas('products', [
            'name' => 'Aqua Flask Tumbler',
            'qty' => 24,
            'price' => 549.00,
        ]);
    }

    public function test_missing_description_is_allowed(): void
    {
        $this->actingAs($this->admin())
            ->post(route('product.store'), [
                'name' => 'No Description Product',
                'qty' => 1,
                'price' => 99,
            ])
            ->assertRedirect(route('product.index'));

        $this->assertDatabaseHas('products', [
            'name' => 'No Description Product',
            'description' => null,
        ]);
    }

    public function test_previously_entered_values_are_preserved_when_validation_fails(): void
    {
        $this->actingAs($this->admin())
            ->from(route('product.create'))
            ->post(route('product.store'), [
                'name' => 'Kept Product Name',
                'qty' => 3,
                'price' => -1,
            ])
            ->assertRedirect(route('product.create'))
            ->assertSessionHasErrors('price');

        $this->actingAs($this->admin())
            ->get(route('product.create'))
            ->assertOk()
            ->assertSee('Kept Product Name');
    }

    public function test_update_rejects_invalid_data_and_keeps_the_original_values(): void
    {
        $product = Product::factory()->create([
            'name' => 'Original Name',
            'qty' => 5,
            'price' => 100,
        ]);

        $this->actingAs($this->admin())
            ->put(route('product.update', ['product' => $product]), [
                'name' => 'Changed Name',
                'qty' => 5,
                'price' => -20,
            ])
            ->assertSessionHasErrors('price');

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Original Name',
            'price' => 100,
        ]);
    }

    private function admin(): User
    {
        return User::factory()->admin()->create();
    }
}
