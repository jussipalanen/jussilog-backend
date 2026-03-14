<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id'             => User::factory(),
            'order_number'        => 'ORD-' . fake()->unique()->numerify('######'),
            'status'              => 'pending',
            'total_amount'        => fake()->randomFloat(2, 10, 500),
            'customer_first_name' => fake()->firstName(),
            'customer_last_name'  => fake()->lastName(),
            'customer_email'      => fake()->safeEmail(),
            'customer_phone'      => fake()->phoneNumber(),
            'billing_address'     => [
                'street'      => fake()->streetAddress(),
                'city'        => fake()->city(),
                'postal_code' => fake()->postcode(),
                'country'     => 'FI',
            ],
            'shipping_address'    => [
                'street'      => fake()->streetAddress(),
                'city'        => fake()->city(),
                'postal_code' => fake()->postcode(),
                'country'     => 'FI',
            ],
            'notes'               => null,
        ];
    }
}
