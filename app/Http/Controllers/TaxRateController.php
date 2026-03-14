<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaxRateController extends Controller
{
    private const SUPPORTED_LANGUAGES = ['en', 'fi'];

    /**
     * Standard VAT/GST rates per country code (ISO 3166-1 alpha-2).
     * Values are decimal rates (e.g. 0.20 = 20%).
     */
    private const TAX_RATES = [
        // Zero rate
        'ZERO' => 0.0,

        // Europe (EU + EFTA/UK)
        'AT' => 0.20,   // Austria
        'BE' => 0.21,   // Belgium
        'BG' => 0.20,   // Bulgaria
        'HR' => 0.25,   // Croatia
        'CY' => 0.19,   // Cyprus
        'CZ' => 0.21,   // Czech Republic
        'DK' => 0.25,   // Denmark
        'EE' => 0.24,   // Estonia
        'FI' => 0.255,  // Finland
        'FR' => 0.20,   // France
        'DE' => 0.19,   // Germany
        'GR' => 0.24,   // Greece
        'HU' => 0.27,   // Hungary
        'IE' => 0.23,   // Ireland
        'IT' => 0.22,   // Italy
        'LV' => 0.21,   // Latvia
        'LT' => 0.21,   // Lithuania
        'LU' => 0.17,   // Luxembourg
        'MT' => 0.18,   // Malta
        'NL' => 0.21,   // Netherlands
        'PL' => 0.23,   // Poland
        'PT' => 0.23,   // Portugal
        'RO' => 0.19,   // Romania
        'SK' => 0.20,   // Slovakia
        'SI' => 0.22,   // Slovenia
        'ES' => 0.21,   // Spain
        'SE' => 0.25,   // Sweden
        'UK' => 0.20,   // United Kingdom
        'NO' => 0.25,   // Norway
        'CH' => 0.081,  // Switzerland

        // Americas
        'AR' => 0.21,   // Argentina
        'BR' => 0.17,   // Brazil
        'CA' => 0.05,   // Canada
        'MX' => 0.16,   // Mexico

        // Asia-Pacific
        'AU' => 0.10,   // Australia
        'CN' => 0.13,   // China
        'ID' => 0.11,   // Indonesia
        'IN' => 0.18,   // India
        'JP' => 0.10,   // Japan
        'KR' => 0.10,   // South Korea
        'NZ' => 0.15,   // New Zealand
        'PH' => 0.12,   // Philippines
        'SG' => 0.09,   // Singapore
        'TH' => 0.07,   // Thailand

        // Middle East
        'AE' => 0.05,   // UAE
        'IL' => 0.17,   // Israel
        'SA' => 0.15,   // Saudi Arabia

        // Africa
        'EG' => 0.14,   // Egypt
        'GH' => 0.15,   // Ghana
        'KE' => 0.16,   // Kenya
        'NG' => 0.075,  // Nigeria
        'ZA' => 0.15,   // South Africa
    ];

    /**
     * Country name translations keyed by ISO 3166-1 alpha-2 code.
     */
    private const COUNTRY_NAMES = [
        'en' => [
            'ZERO' => 'No Tax (0%)',
            'AT'   => 'Austria',
            'BE'   => 'Belgium',
            'BG'   => 'Bulgaria',
            'HR'   => 'Croatia',
            'CY'   => 'Cyprus',
            'CZ'   => 'Czech Republic',
            'DK'   => 'Denmark',
            'EE'   => 'Estonia',
            'FI'   => 'Finland',
            'FR'   => 'France',
            'DE'   => 'Germany',
            'GR'   => 'Greece',
            'HU'   => 'Hungary',
            'IE'   => 'Ireland',
            'IT'   => 'Italy',
            'LV'   => 'Latvia',
            'LT'   => 'Lithuania',
            'LU'   => 'Luxembourg',
            'MT'   => 'Malta',
            'NL'   => 'Netherlands',
            'PL'   => 'Poland',
            'PT'   => 'Portugal',
            'RO'   => 'Romania',
            'SK'   => 'Slovakia',
            'SI'   => 'Slovenia',
            'ES'   => 'Spain',
            'SE'   => 'Sweden',
            'UK'   => 'United Kingdom',
            'NO'   => 'Norway',
            'CH'   => 'Switzerland',
            'AR'   => 'Argentina',
            'BR'   => 'Brazil',
            'CA'   => 'Canada',
            'MX'   => 'Mexico',
            'AU'   => 'Australia',
            'CN'   => 'China',
            'ID'   => 'Indonesia',
            'IN'   => 'India',
            'JP'   => 'Japan',
            'KR'   => 'South Korea',
            'NZ'   => 'New Zealand',
            'PH'   => 'Philippines',
            'SG'   => 'Singapore',
            'TH'   => 'Thailand',
            'AE'   => 'United Arab Emirates',
            'IL'   => 'Israel',
            'SA'   => 'Saudi Arabia',
            'EG'   => 'Egypt',
            'GH'   => 'Ghana',
            'KE'   => 'Kenya',
            'NG'   => 'Nigeria',
            'ZA'   => 'South Africa',
        ],
        'fi' => [
            'ZERO' => 'Veroton (0%)',
            'AT'   => 'Itävalta',
            'BE'   => 'Belgia',
            'BG'   => 'Bulgaria',
            'HR'   => 'Kroatia',
            'CY'   => 'Kypros',
            'CZ'   => 'Tšekki',
            'DK'   => 'Tanska',
            'EE'   => 'Viro',
            'FI'   => 'Suomi',
            'FR'   => 'Ranska',
            'DE'   => 'Saksa',
            'GR'   => 'Kreikka',
            'HU'   => 'Unkari',
            'IE'   => 'Irlanti',
            'IT'   => 'Italia',
            'LV'   => 'Latvia',
            'LT'   => 'Liettua',
            'LU'   => 'Luxemburg',
            'MT'   => 'Malta',
            'NL'   => 'Alankomaat',
            'PL'   => 'Puola',
            'PT'   => 'Portugali',
            'RO'   => 'Romania',
            'SK'   => 'Slovakia',
            'SI'   => 'Slovenia',
            'ES'   => 'Espanja',
            'SE'   => 'Ruotsi',
            'UK'   => 'Yhdistynyt kuningaskunta',
            'NO'   => 'Norja',
            'CH'   => 'Sveitsi',
            'AR'   => 'Argentiina',
            'BR'   => 'Brasilia',
            'CA'   => 'Kanada',
            'MX'   => 'Meksiko',
            'AU'   => 'Australia',
            'CN'   => 'Kiina',
            'ID'   => 'Indonesia',
            'IN'   => 'Intia',
            'JP'   => 'Japani',
            'KR'   => 'Etelä-Korea',
            'NZ'   => 'Uusi-Seelanti',
            'PH'   => 'Filippiinit',
            'SG'   => 'Singapore',
            'TH'   => 'Thaimaa',
            'AE'   => 'Yhdistyneet arabiemiirikunnat',
            'IL'   => 'Israel',
            'SA'   => 'Saudi-Arabia',
            'EG'   => 'Egypti',
            'GH'   => 'Ghana',
            'KE'   => 'Kenia',
            'NG'   => 'Nigeria',
            'ZA'   => 'Etelä-Afrikka',
        ],
    ];

    /**
     * Return all available tax rates with translated country names.
     *
     * @group Tax Rates
     *
     * @unauthenticated
     *
     * @queryParam lang string Language code for country name translation (en, fi). Defaults to en. Example: fi
     */
    public function index(Request $request): JsonResponse
    {
        $lang = in_array($request->query('lang'), self::SUPPORTED_LANGUAGES, true)
            ? (string) $request->query('lang')
            : 'en';

        $names = self::COUNTRY_NAMES[$lang];

        $rates = array_map(
            fn (string $code, float $rate) => [
                'code'  => $code,
                'label' => $names[$code],
                'rate'  => $rate,
            ],
            array_keys(self::TAX_RATES),
            array_values(self::TAX_RATES),
        );

        return response()->json($rates);
    }

    /**
     * Return the tax rate for a specific country code.
     *
     * @group Tax Rates
     *
     * @unauthenticated
     *
     * @urlParam code string required ISO 3166-1 alpha-2 country code (or ZERO). Example: FI
     *
     * @queryParam lang string Language code for country name translation (en, fi). Defaults to en. Example: fi
     */
    public function show(Request $request, string $code): JsonResponse
    {
        $code = strtoupper($code);

        if (! array_key_exists($code, self::TAX_RATES)) {
            return response()->json(['message' => 'Tax rate not found for country code: '.$code], 404);
        }

        $lang = in_array($request->query('lang'), self::SUPPORTED_LANGUAGES, true)
            ? (string) $request->query('lang')
            : 'en';

        $names = self::COUNTRY_NAMES[$lang];

        return response()->json([
            'code'  => $code,
            'label' => $names[$code],
            'rate'  => self::TAX_RATES[$code],
        ]);
    }
}
