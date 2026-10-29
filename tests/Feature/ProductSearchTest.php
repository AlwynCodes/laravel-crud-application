<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_filters_products_by_name(): void
    {
        Product::factory()->create(['name' => 'Wireless Headphones']);
        Product::factory()->create(['name' => 'Mechanical Keyboard']);

        $this->actingAs($this->user())
            ->get(route('product.index', ['search' => 'Headphones']))
            ->assertOk()
            ->assertSee('Wireless Headphones')
            ->assertDontSee('Mechanical Keyboard');
    }

    public function test_search_is_case_insensitive(): void
    {
        Product::factory()->create(['name' => 'Bluetooth Speaker']);

        $this->actingAs($this->user())
            ->get(route('product.index', ['search' => 'bluetooth']))
            ->assertOk()
            ->assertSee('Bluetooth Speaker');
    }

    public function test_listing_is_paginated_to_eight_records(): void
    {
        Product::factory()->count(10)->create();

        $response = $this->actingAs($this->user())->get(route('product.index'));

        $response->assertOk();

        $products = $response->viewData('products');

        $this->assertCount(8, $products);
        $this->assertSame(10, $products->total());
        $this->assertSame(2, $products->lastPage());
    }

    public function test_pagination_links_keep_the_search_keyword(): void
    {
        Product::factory()->count(12)->sequence(
            fn ($sequence): array => ['name' => 'Widget '.$sequence->index],
        )->create();

        $response = $this->actingAs($this->user())
            ->get(route('product.index', ['search' => 'Widget']))
            ->assertOk();

        $this->assertSame(12, $response->viewData('products')->total());
        $this->assertStringContainsString('search=Widget', $response->getContent());
    }

    public function test_empty_state_message_is_shown_when_nothing_matches(): void
    {
        Product::factory()->create(['name' => 'Mechanical Keyboard']);

        $this->actingAs($this->user())
            ->get(route('product.index', ['search' => 'nonexistent']))
            ->assertOk()
            ->assertSee('No products matched your search')
            ->assertDontSee('Mechanical Keyboard');
    }

    public function test_overly_long_search_terms_are_rejected(): void
    {
        $this->actingAs($this->user())
            ->get(route('product.index', ['search' => str_repeat('a', 101)]))
            ->assertSessionHasErrors('search');
    }

    private function user(): User
    {
        return User::factory()->create();
    }
}
