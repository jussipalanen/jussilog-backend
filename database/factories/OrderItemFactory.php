<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    public function definition(): array
    {
        $quantity  = fake()->numberBetween(1, 5);
        $unitPrice = fake()->randomFloat(2, 5, 200);

        return [
            'order_id'      => Order::factory(),
            'product_id'    => null,
            'product_title' => fake()->words(3, true),
            'quantity'      => $quantity,
            'unit_price'    => $unitPrice,
            'sale_price'    => null,
            'subtotal'      => $quantity * $unitPrice,
        ];
    }
}
