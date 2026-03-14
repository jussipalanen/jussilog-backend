<?php

declare(strict_types=1);

namespace App\Translations;

class InvoiceTranslations
{
    private const SUPPORTED = ['en', 'fi'];

    public static function get(string $lang): array
    {
        $locale = in_array($lang, self::SUPPORTED, true) ? $lang : 'en';

        // Use include (not require) so PHP doesn't serve a cached opcode result
        // when the same process loads both en and fi in the same request.
        return include base_path("lang/{$locale}/invoice.php");
    }
}
