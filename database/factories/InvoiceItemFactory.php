<?php

namespace Database\Factories;

use App\Enums\InvoiceItemType;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InvoiceItem>
 */
class InvoiceItemFactory extends Factory
{
    public function definition(): array
    {
        $quantity  = fake()->numberBetween(1, 5);
        $unitPrice = fake()->randomFloat(2, 5, 200);

        return [
            'invoice_id'    => Invoice::factory(),
            'order_item_id' => null,
            'type'          => InvoiceItemType::PRODUCT,
            'description'   => fake()->words(3, true),
            'quantity'      => $quantity,
            'unit_price'    => $unitPrice,
            'tax_rate'      => 0,
            'total'         => $quantity * $unitPrice,
        ];
    }
}
