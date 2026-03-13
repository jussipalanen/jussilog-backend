<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    private const LANGUAGES = [
        'en' => 'resume_pdf.language_en',
        'fi' => 'resume_pdf.language_fi',
    ];

    /**
     * Return the list of supported languages with translated labels.
     * Pass `?lang=fi` to receive labels in Finnish (default: `en`).
     *
     * @group Settings
     * @unauthenticated
     */
    public function languages(Request $request): JsonResponse
    {
        $locale = in_array($request->query('lang'), array_keys(self::LANGUAGES))
            ? $request->query('lang')
            : 'en';
        app()->setLocale($locale);

        $languages = array_map(
            fn ($value, $translationKey) => ['value' => $value, 'label' => __($translationKey)],
            array_keys(self::LANGUAGES),
            self::LANGUAGES
        );

        return response()->json(array_values($languages));
    }
}
