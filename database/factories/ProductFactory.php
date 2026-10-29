<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(3, true),
            'qty' => fake()->numberBetween(0, 120),
            'price' => fake()->randomFloat(2, 50, 20000),
            'description' => fake()->sentence(10),
            'image_path' => null,
        ];
    }

    /**
     * Give the product an existing uploaded image path.
     */
    public function withImage(string $path = 'products/sample.png'): static
    {
        return $this->state(fn (): array => ['image_path' => $path]);
    }
}
