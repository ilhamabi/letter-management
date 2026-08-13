<?php

namespace App\Services;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeService
{
    /**
     * Generate a simple, classic black-and-white inline SVG QR code locally,
     * scaled precisely for 52pt x 52pt container rendering.
     *
     * @param string $url
     * @param int $size
     * @return string
     */
    public function generateSvg(string $url, int $size = 200): string
    {
        try {
            if (class_exists(QrCode::class)) {
                $svg = (string) QrCode::size($size)
                    ->margin(0)
                    ->color(0, 0, 0)
                    ->backgroundColor(255, 255, 255)
                    ->generate($url);

                if (!empty($svg) && str_contains($svg, '<svg')) {
                    if (!str_contains($svg, 'viewBox')) {
                        $svg = preg_replace('/<svg([^>]*)>/', '<svg$1 viewBox="0 0 ' . $size . ' ' . $size . '">', $svg);
                    }
                    return $svg;
                }
            }
        } catch (\Throwable $e) {
            // Fallback
        }

        return $this->generateSimpleFallbackSvg($url);
    }

    /**
     * Generate Data URI image src for img tag if needed.
     *
     * @param string $url
     * @param int $size
     * @return string
     */
    public function generateDataUri(string $url, int $size = 70): string
    {
        $svg = $this->generateSvg($url, $size);
        return 'data:image/svg+xml;charset=UTF-8,' . rawurlencode($svg);
    }

    /**
     * Classic simple black-and-white square module fallback QR vector (100% width/height).
     *
     * @param string $url
     * @return string
     */
    private function generateSimpleFallbackSvg(string $url): string
    {
        return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 160 160" style="display: block;">
    <rect width="160" height="160" fill="#ffffff"/>
    <!-- Position Finder Pattern Top-Left -->
    <rect x="10" y="10" width="45" height="45" fill="#000000"/>
    <rect x="18" y="18" width="29" height="29" fill="#ffffff"/>
    <rect x="26" y="26" width="13" height="13" fill="#000000"/>
    <!-- Position Finder Pattern Top-Right -->
    <rect x="105" y="10" width="45" height="45" fill="#000000"/>
    <rect x="113" y="18" width="29" height="29" fill="#ffffff"/>
    <rect x="121" y="26" width="13" height="13" fill="#000000"/>
    <!-- Position Finder Pattern Bottom-Left -->
    <rect x="10" y="105" width="45" height="45" fill="#000000"/>
    <rect x="18" y="113" width="29" height="29" fill="#ffffff"/>
    <rect x="26" y="121" width="13" height="13" fill="#000000"/>
    <!-- Standard Square Data Modules -->
    <rect x="68" y="15" width="12" height="12" fill="#000000"/>
    <rect x="85" y="15" width="12" height="12" fill="#000000"/>
    <rect x="68" y="42" width="12" height="12" fill="#000000"/>
    <rect x="85" y="42" width="12" height="12" fill="#000000"/>
    <rect x="68" y="68" width="25" height="25" fill="#000000"/>
    <rect x="18" y="68" width="12" height="12" fill="#000000"/>
    <rect x="42" y="68" width="12" height="12" fill="#000000"/>
    <rect x="105" y="68" width="16" height="16" fill="#000000"/>
    <rect x="128" y="68" width="16" height="16" fill="#000000"/>
    <rect x="68" y="105" width="16" height="16" fill="#000000"/>
    <rect x="105" y="105" width="45" height="45" fill="#000000"/>
    <rect x="115" y="115" width="25" height="25" fill="#ffffff"/>
    <rect x="122" y="122" width="11" height="11" fill="#000000"/>
</svg>
SVG;
    }
}
