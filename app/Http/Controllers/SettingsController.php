<?php

namespace App\Http\Controllers;

use App\Services\CountryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    private const LANGUAGES = [
        'en' => 'resume.language_en',
        'fi' => 'resume.language_fi',
    ];

    private const SUPPORTED_LOCALES = ['en', 'fi'];

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

    /**
     * Return the list of world countries with translated labels.
     * Pass `?lang=fi` to receive labels in Finnish (default: `en`).
     *
     * @group Settings
     * @unauthenticated
     */
    public function countries(Request $request): JsonResponse
    {
        $locale = in_array($request->query('lang'), self::SUPPORTED_LOCALES)
            ? $request->query('lang')
            : 'en';

        $countries = array_map(
            fn ($country) => ['value' => $country['value'], 'label' => $country[$locale]],
            CountryService::all()
        );

        return response()->json($countries);
    }

    /**
     * Return a single country by its ISO 3166-1 alpha-2 code.
     * Pass `?lang=fi` to receive the label in Finnish (default: `en`).
     *
     * @group Settings
     * @unauthenticated
     * @urlParam code string required The ISO 3166-1 alpha-2 country code. Example: FI
     */
    public function country(Request $request, string $code): JsonResponse
    {
        $locale = in_array($request->query('lang'), self::SUPPORTED_LOCALES)
            ? $request->query('lang')
            : 'en';

        $label = CountryService::getLabel($code, $locale);
        $normalized = strtoupper($code);

        // getLabel returns the raw code when not found
        if ($label === $normalized && !in_array($normalized, array_column(CountryService::all(), 'value'))) {
            return response()->json(['message' => 'Country not found.'], 404);
        }

        return response()->json(['value' => $normalized, 'label' => $label]);
    }
}

