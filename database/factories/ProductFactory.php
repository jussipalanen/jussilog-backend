<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
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

        // Default to Finnish standard VAT rate
        $taxCode = 'FI';
        $taxRate = 0.255;

        return [
            'title'          => fake()->words(3, true),
            'description'    => fake()->paragraphs(3, true),
            'price'          => $price,
            'sale_price'     => null,
            'tax_code'       => $taxCode,
            'tax_rate'       => $taxRate,
            'quantity'       => fake()->numberBetween(0, 500),
            'featured_image' => null,
            'images'         => [],
            'visibility'     => true,
        ];
    }
}
