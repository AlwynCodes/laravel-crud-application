<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_view_products(): void
    {
        $this->get(route('product.index'))->assertRedirect(route('login'));
    }

    public function test_regular_user_can_view_the_listing_and_details(): void
    {
        $product = Product::factory()->create(['name' => 'Visible Product']);

        $this->actingAs($this->regularUser())
            ->get(route('product.index'))
            ->assertOk()
            ->assertSee('Visible Product');

        $this->actingAs($this->regularUser())
            ->get(route('product.show', ['product' => $product]))
            ->assertOk()
            ->assertSee('Visible Product');
    }

    public function test_regular_user_cannot_open_management_pages(): void
    {
        $product = Product::factory()->create();
        $user = $this->regularUser();

        $this->actingAs($user)->get(route('product.create'))->assertForbidden();
        $this->actingAs($user)->get(route('product.edit', ['product' => $product]))->assertForbidden();
    }

    public function test_regular_user_cannot_create_update_or_delete_products(): void
    {
        $product = Product::factory()->create([
            'name' => 'Protected Product',
            'qty' => 4,
            'price' => 100,
        ]);
        $user = $this->regularUser();

        $this->actingAs($user)
            ->post(route('product.store'), [
                'name' => 'Injected Product',
                'qty' => 1,
                'price' => 10,
            ])
            ->assertForbidden();

        $this->actingAs($user)
            ->put(route('product.update', ['product' => $product]), [
                'name' => 'Hijacked Product',
                'qty' => 1,
                'price' => 1,
            ])
            ->assertForbidden();

        $this->actingAs($user)
            ->delete(route('product.destroy', ['product' => $product]))
            ->assertForbidden();

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Protected Product',
            'price' => 100,
        ]);
        $this->assertDatabaseMissing('products', ['name' => 'Injected Product']);
    }

    public function test_management_buttons_are_hidden_from_regular_users(): void
    {
        Product::factory()->create(['name' => 'Catalogue Item']);

        $this->actingAs($this->regularUser())
            ->get(route('product.index'))
            ->assertOk()
            ->assertDontSee('+ Add Product')
            ->assertDontSee('Delete this product and its image?');
    }

    public function test_administrator_sees_management_actions_and_can_delete(): void
    {
        $product = Product::factory()->create(['name' => 'Removable Product']);

        $this->actingAs($this->admin())
            ->get(route('product.index'))
            ->assertOk()
            ->assertSee('+ Add Product');

        $this->actingAs($this->admin())
            ->delete(route('product.destroy', ['product' => $product]))
            ->assertRedirect(route('product.index'));

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_administrator_can_create_and_update_products(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)
            ->post(route('product.store'), [
                'name' => 'Admin Created',
                'qty' => 7,
                'price' => 250,
            ])
            ->assertRedirect(route('product.index'));

        $product = Product::query()->where('name', 'Admin Created')->firstOrFail();

        $this->actingAs($admin)
            ->put(route('product.update', ['product' => $product]), [
                'name' => 'Admin Updated',
                'qty' => 3,
                'price' => 275.50,
            ])
            ->assertRedirect(route('product.index'));

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Admin Updated',
            'qty' => 3,
            'price' => 275.50,
        ]);
    }

    public function test_newly_registered_accounts_receive_the_user_role(): void
    {
        $this->post(route('register'), [
            'name' => 'New Student',
            'email' => 'student@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertRedirect();

        $this->assertDatabaseHas('users', [
            'email' => 'student@example.com',
            'role' => User::ROLE_USER,
        ]);
    }

    public function test_registration_ignores_a_role_submitted_in_the_request(): void
    {
        $this->post(route('register'), [
            'name' => 'Sneaky Student',
            'email' => 'sneaky@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => User::ROLE_ADMIN,
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'sneaky@example.com',
            'role' => User::ROLE_USER,
        ]);
    }

    private function admin(): User
    {
        return User::factory()->admin()->create();
    }

    private function regularUser(): User
    {
        return User::factory()->create();
    }
}
