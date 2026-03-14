<?php

declare(strict_types=1);

namespace App\Enums;

enum InvoiceStatus: string
{
    case DRAFT     = 'draft';
    case ISSUED    = 'issued';
    case UNPAID    = 'unpaid';
    case OVERDUE   = 'overdue';
    case PAID      = 'paid';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT     => 'Draft',
            self::ISSUED    => 'Issued',
            self::UNPAID    => 'Unpaid',
            self::OVERDUE   => 'Overdue',
            self::PAID      => 'Paid',
            self::CANCELLED => 'Cancelled',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::DRAFT     => 'gray',
            self::ISSUED    => 'blue',
            self::UNPAID    => 'orange',
            self::OVERDUE   => 'red',
            self::PAID      => 'green',
            self::CANCELLED => 'gray',
        };
    }
}
