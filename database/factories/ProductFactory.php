<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $price = fake()->numberBetween(1, 100) * 10;

        return [
            'title' => fake()->words(3, true),
            'description' => fake()->paragraphs(3, true),
            'price' => $price,
            'sale_price' => null,
            'quantity' => fake()->numberBetween(0, 500),
            'featured_image' => null,
            'images' => [],
            'visibility' => true,
        ];
    }
}