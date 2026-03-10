<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\InvoiceItemType;
use App\Enums\InvoiceStatus;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure we have a user and at least one product
        $user = User::first() ?? User::factory()->create();

        $product1 = Product::firstOrCreate(
            ['title' => 'Wireless Headphones'],
            ['price' => 79.99, 'description' => 'Example product for seeding']
        );

        $product2 = Product::firstOrCreate(
            ['title' => 'USB-C Cable'],
            ['price' => 4.99, 'description' => 'Example product for seeding']
        );

        // Create a sample order
        $order = Order::create(
            [
            'user_id'            => $user->id,
            'order_number'       => 'ORD-' . date('Y') . '-' . str_pad((string) (Order::count() + 1), 5, '0', STR_PAD_LEFT),
            'customer_first_name' => 'Jussi',
            'customer_last_name'  => 'Palanen',
            'customer_email'      => 'jussi@example.com',
            'customer_phone'      => '+358401234567',
            'status'             => 'completed',
            'total_amount'       => 89.97,
            'billing_address'    => [
                'street'      => 'Mannerheimintie 1',
                'city'        => 'Helsinki',
                'postal_code' => '00100',
                'country'     => 'FI',
            ],
            'shipping_address' => [
                'street'      => 'Mannerheimintie 1',
                'city'        => 'Helsinki',
                'postal_code' => '00100',
                'country'     => 'FI',
            ],
            ]
        );

        $orderItem1 = OrderItem::create(
            [
            'order_id'     => $order->id,
            'product_id'   => $product1->id,
            'product_title' => $product1->title,
            'quantity'     => 1,
            'unit_price'   => 79.99,
            'subtotal'     => 79.99,
            ]
        );

        $orderItem2 = OrderItem::create(
            [
            'order_id'     => $order->id,
            'product_id'   => $product2->id,
            'product_title' => $product2->title,
            'quantity'     => 2,
            'unit_price'   => 4.99,
            'subtotal'     => 9.98,
            ]
        );

        // Create the invoice
        $invoice = Invoice::create(
            [
            'order_id'           => $order->id,
            'user_id'            => $user->id,
            'invoice_number'     => 'INV-' . date('Y') . '-' . str_pad((string) (Invoice::count() + 1), 5, '0', STR_PAD_LEFT),
            'customer_first_name' => $order->customer_first_name,
            'customer_last_name'  => $order->customer_last_name,
            'customer_email'      => $order->customer_email,
            'customer_phone'      => $order->customer_phone,
            'billing_address'    => $order->billing_address,
            'subtotal'           => 89.97,
            'total'              => 89.97,
            'status'             => InvoiceStatus::ISSUED,
            'issued_at'          => now(),
            'paid_at'            => null,
            'notes'              => 'Net 30',
            ]
        );

        // Product line items copied from order
        InvoiceItem::create(
            [
            'invoice_id'    => $invoice->id,
            'order_item_id' => $orderItem1->id,
            'type'          => InvoiceItemType::PRODUCT,
            'description'   => $orderItem1->product_title,
            'quantity'      => $orderItem1->quantity,
            'unit_price'    => $orderItem1->unit_price,
            'tax_rate'      => 0.2400,
            'total'         => $orderItem1->subtotal,
            ]
        );

        InvoiceItem::create(
            [
            'invoice_id'    => $invoice->id,
            'order_item_id' => $orderItem2->id,
            'type'          => InvoiceItemType::PRODUCT,
            'description'   => $orderItem2->product_title,
            'quantity'      => $orderItem2->quantity,
            'unit_price'    => $orderItem2->unit_price,
            'tax_rate'      => 0.2400,
            'total'         => $orderItem2->subtotal,
            ]
        );

        // Shipping line item (no linked order item)
        InvoiceItem::create(
            [
            'invoice_id'    => $invoice->id,
            'order_item_id' => null,
            'type'          => InvoiceItemType::SHIPPING,
            'description'   => 'Standard Shipping',
            'quantity'      => 1,
            'unit_price'    => 0.00,
            'tax_rate'      => 0.0000,
            'total'         => 0.00,
            ]
        );

        $this->command->info("Invoice seeded: {$invoice->invoice_number} ({$order->order_number})");
    }
}
