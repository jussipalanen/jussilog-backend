<?php

namespace Tests\Unit\Enums;

use App\Enums\InvoiceStatus;
use Tests\TestCase;

class InvoiceStatusTest extends TestCase
{
    public function test_label_returns_correct_string_for_each_case(): void
    {
        $this->assertSame('Draft', InvoiceStatus::DRAFT->label());
        $this->assertSame('Issued', InvoiceStatus::ISSUED->label());
        $this->assertSame('Paid', InvoiceStatus::PAID->label());
        $this->assertSame('Cancelled', InvoiceStatus::CANCELLED->label());
    }

    public function test_color_returns_correct_string_for_each_case(): void
    {
        $this->assertSame('gray', InvoiceStatus::DRAFT->color());
        $this->assertSame('blue', InvoiceStatus::ISSUED->color());
        $this->assertSame('green', InvoiceStatus::PAID->color());
        $this->assertSame('red', InvoiceStatus::CANCELLED->color());
    }

    public function test_from_resolves_valid_values(): void
    {
        $this->assertSame(InvoiceStatus::DRAFT, InvoiceStatus::from('draft'));
        $this->assertSame(InvoiceStatus::ISSUED, InvoiceStatus::from('issued'));
        $this->assertSame(InvoiceStatus::PAID, InvoiceStatus::from('paid'));
        $this->assertSame(InvoiceStatus::CANCELLED, InvoiceStatus::from('cancelled'));
    }

    public function test_from_throws_on_invalid_value(): void
    {
        $this->expectException(\ValueError::class);

        InvoiceStatus::from('unknown');
    }

    public function test_try_from_returns_null_on_invalid_value(): void
    {
        $this->assertNull(InvoiceStatus::tryFrom('unknown'));
    }

    public function test_cases_returns_all_four_statuses(): void
    {
        $this->assertCount(4, InvoiceStatus::cases());
    }
}
