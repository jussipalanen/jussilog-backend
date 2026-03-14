<?php

namespace Database\Factories;

use App\Enums\InvoiceStatus;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    public function definition(): array
    {
        $subtotal = fake()->randomFloat(2, 10, 500);

        return [
            'order_id'            => Order::factory(),
            'user_id'             => User::factory(),
            'invoice_number'      => 'INV-' . date('Y') . '-' . fake()->unique()->numerify('#####'),
            'customer_first_name' => fake()->firstName(),
            'customer_last_name'  => fake()->lastName(),
            'customer_email'      => fake()->safeEmail(),
            'customer_phone'      => null,
            'billing_address'     => [
                'street'      => fake()->streetAddress(),
                'city'        => fake()->city(),
                'postal_code' => fake()->postcode(),
                'country'     => 'FI',
            ],
            'subtotal'            => $subtotal,
            'total'               => $subtotal,
            'status'              => InvoiceStatus::DRAFT,
            'issued_at'           => null,
            'paid_at'             => null,
            'notes'               => null,
        ];
    }

    public function issued(): static
    {
        return $this->state(fn () => [
            'status'    => InvoiceStatus::ISSUED,
            'issued_at' => now(),
        ]);
    }

    public function paid(): static
    {
        return $this->state(fn () => [
            'status'  => InvoiceStatus::PAID,
            'paid_at' => now(),
        ]);
    }
}
