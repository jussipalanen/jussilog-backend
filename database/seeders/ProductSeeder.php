<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Finnish VAT rates (ALV):
     *  - 25.5%  standard rate (most goods & services)
     *  - 14%    reduced rate (food, restaurant services)
     *  - 10%    reduced rate (books, medicine, public transport, cultural events)
     *  - 0%     zero rate (tax-exempt items)
     */
    private const FI_TAX_RATES = [
        ['tax_code' => 'FI',   'tax_rate' => 0.255,  'label' => 'Standard (25.5%)'],
        ['tax_code' => 'FI',   'tax_rate' => 0.14,   'label' => 'Reduced 14% (food)'],
        ['tax_code' => 'FI',   'tax_rate' => 0.10,   'label' => 'Reduced 10% (books/medicine)'],
        ['tax_code' => 'ZERO', 'tax_rate' => 0.0,    'label' => 'Zero rate'],
    ];

    public function run(): void
    {
        foreach (self::FI_TAX_RATES as $taxInfo) {
            Product::factory()->count(3)->create([
                'tax_code' => $taxInfo['tax_code'],
                'tax_rate' => $taxInfo['tax_rate'],
            ]);
        }
    }
}
