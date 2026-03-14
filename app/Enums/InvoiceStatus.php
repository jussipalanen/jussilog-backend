<?php

declare(strict_types=1);

namespace App\Enums;

enum InvoiceStatus: string
{
    case DRAFT = 'draft';
    case ISSUED = 'issued';
    case PAID = 'paid';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::ISSUED => 'Issued',
            self::PAID => 'Paid',
            self::CANCELLED => 'Cancelled',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::DRAFT => 'gray',
            self::ISSUED => 'blue',
            self::PAID => 'green',
            self::CANCELLED => 'red',
        };
    }
}
