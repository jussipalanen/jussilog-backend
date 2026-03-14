<?php

namespace Tests\Unit\Translations;

use App\Translations\MailTranslations;
use Tests\TestCase;

class MailTranslationsTest extends TestCase
{
    public function test_get_returns_english_account_deleted_translations(): void
    {
        $t = MailTranslations::get('account_deleted', 'en');

        $this->assertIsArray($t);
        $this->assertSame('Account Removed', $t['badge']);
        $this->assertSame('All rights reserved.', $t['all_rights']);
    }

    public function test_get_returns_finnish_account_deleted_translations(): void
    {
        $t = MailTranslations::get('account_deleted', 'fi');

        $this->assertIsArray($t);
        $this->assertSame('Tili poistettu', $t['badge']);
        $this->assertSame('Kaikki oikeudet pidätetään.', $t['all_rights']);
    }

    public function test_get_returns_english_order_confirmation_translations(): void
    {
        $t = MailTranslations::get('order_confirmation', 'en');

        $this->assertSame('Order Confirmation', $t['badge']);
        $this->assertSame('Customer', $t['customer']);
        $this->assertSame('Order Total', $t['order_total']);
    }

    public function test_get_returns_finnish_order_confirmation_translations(): void
    {
        $t = MailTranslations::get('order_confirmation', 'fi');

        $this->assertSame('Tilausvahvistus', $t['badge']);
        $this->assertSame('Asiakas', $t['customer']);
        $this->assertSame('Tilauksen kokonaissumma', $t['order_total']);
    }

    public function test_get_returns_english_registration_welcome_translations(): void
    {
        $t = MailTranslations::get('registration_welcome', 'en');

        $this->assertSame('New Account', $t['badge']);
    }

    public function test_get_returns_finnish_registration_welcome_translations(): void
    {
        $t = MailTranslations::get('registration_welcome', 'fi');

        $this->assertSame('Uusi tili', $t['badge']);
    }

    public function test_get_returns_english_google_welcome_translations(): void
    {
        $t = MailTranslations::get('google_welcome', 'en');

        $this->assertSame('Google Sign-In', $t['badge']);
    }

    public function test_get_returns_finnish_google_welcome_translations(): void
    {
        $t = MailTranslations::get('google_welcome', 'fi');

        $this->assertSame('Google-kirjautuminen', $t['badge']);
    }

    public function test_unknown_template_returns_empty_array(): void
    {
        $t = MailTranslations::get('no_such_template', 'en');

        $this->assertSame([], $t);
    }

    public function test_unsupported_locale_falls_back_to_english(): void
    {
        $t = MailTranslations::get('account_deleted', 'de');

        $this->assertSame(MailTranslations::get('account_deleted', 'en'), $t);
    }

    public function test_all_templates_have_matching_keys_in_both_locales(): void
    {
        $templates = ['account_deleted', 'google_welcome', 'order_confirmation', 'registration_welcome'];

        foreach ($templates as $template) {
            $en = MailTranslations::get($template, 'en');
            $fi = MailTranslations::get($template, 'fi');

            $this->assertSame(
                array_keys($en),
                array_keys($fi),
                "Template '{$template}' has mismatched keys between en and fi.",
            );
        }
    }
}
