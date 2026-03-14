<?php

declare(strict_types=1);

namespace App\Enums;

enum InvoiceItemType: string
{
    case PRODUCT    = 'product';
    case SHIPPING   = 'shipping';
    case DISCOUNT   = 'discount';
    case FEE        = 'fee';
    case OTHER      = 'other';
    case ADJUSTMENT = 'adjustment';

    public function label(): string
    {
        return match ($this) {
            self::PRODUCT    => 'Product',
            self::SHIPPING   => 'Shipping',
            self::DISCOUNT   => 'Discount',
            self::FEE        => 'Fee',
            self::OTHER      => 'Other',
            self::ADJUSTMENT => 'Adjustment',
        };
    }
}
