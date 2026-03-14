<?php

namespace Tests\Unit\Translations;

use App\Translations\InvoiceTranslations;
use Tests\TestCase;

class InvoiceTranslationsTest extends TestCase
{
    public function test_get_returns_english_translations(): void
    {
        $t = InvoiceTranslations::get('en');

        $this->assertIsArray($t);
        $this->assertSame('Invoice', $t['invoice']);
        $this->assertSame('Invoice Number', $t['invoice_number']);
        $this->assertSame('Hi', $t['hi']);
        $this->assertSame('Subtotal', $t['subtotal']);
        $this->assertSame('Total', $t['total']);
    }

    public function test_get_returns_finnish_translations(): void
    {
        $t = InvoiceTranslations::get('fi');

        $this->assertIsArray($t);
        $this->assertSame('Lasku', $t['invoice']);
        $this->assertSame('Laskunumero', $t['invoice_number']);
        $this->assertSame('Hei', $t['hi']);
        $this->assertSame('Välisumma', $t['subtotal']);
        $this->assertSame('Yhteensä', $t['total']);
    }

    public function test_unsupported_locale_falls_back_to_english(): void
    {
        $t = InvoiceTranslations::get('de');

        $this->assertSame(InvoiceTranslations::get('en'), $t);
    }

    public function test_english_and_finnish_cover_the_same_keys(): void
    {
        $en = InvoiceTranslations::get('en');
        $fi = InvoiceTranslations::get('fi');

        $this->assertSame(array_keys($en), array_keys($fi));
    }
}
