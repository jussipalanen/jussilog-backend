<?php

declare(strict_types=1);

namespace App\Translations;

class MailTranslations
{
    private const SUPPORTED = ['en', 'fi'];

    public static function get(string $template, string $lang): array
    {
        $locale = in_array($lang, self::SUPPORTED, true) ? $lang : 'en';
        $all    = include base_path("lang/{$locale}/mail.php");

        return $all[$template] ?? [];
    }
}
