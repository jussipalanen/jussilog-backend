<?php

namespace Database\Factories;

use App\Enums\InvoiceItemType;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<InvoiceItem>
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
