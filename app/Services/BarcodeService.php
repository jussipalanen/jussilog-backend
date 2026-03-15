<?php

declare(strict_types=1);

namespace App\Services;

use Picqer\Barcode\BarcodeGeneratorSVG;

class BarcodeService
{
    /**
     * Generate a Code 128 barcode as an inline SVG string.
     * Dark bars — use on light/white backgrounds (e.g. PDF).
     */
    public static function svg(string $text, int $height = 50, int $widthFactor = 2): string
    {
        return (new BarcodeGeneratorSVG())->getBarcode(
            $text,
            BarcodeGeneratorSVG::TYPE_CODE_128,
            $widthFactor,
            $height,
            '#000000',
        );
    }

    /**
     * Generate a Code 128 barcode as an inline SVG string.
     * Light bars — use on dark backgrounds (e.g. dark-themed email).
     */
    public static function svgLight(string $text, int $height = 50, int $widthFactor = 2): string
    {
        return (new BarcodeGeneratorSVG())->getBarcode(
            $text,
            BarcodeGeneratorSVG::TYPE_CODE_128,
            $widthFactor,
            $height,
            '#a5b4fc',
        );
    }
}
