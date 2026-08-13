<?php

namespace App\Services;

use App\Models\Submission;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class PdfGenerationService
{
    public function __construct(
        protected DocumentNamingService $namingService
    ) {}

    /**
     * Generate raw binary PDF content from HTML string.
     *
     * @param string $htmlContent
     * @return string
     */
    public function generatePdfBinary(string $htmlContent): string
    {
        // Inject local base64 logo and CSS if needed for 100% offline Dompdf rendering
        $htmlWithAssets = $this->prepareHtmlForDompdf($htmlContent);

        $pdf = Pdf::loadHTML($htmlWithAssets)
            ->setPaper('a4', 'portrait')
            ->setOption([
                'isRemoteEnabled' => true,
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => false,
                'defaultFont' => 'times',
            ]);

        return $pdf->output();
    }

    /**
     * Generate direct PDF download HTTP response for a submission.
     *
     * @param Submission $submission
     * @param string $htmlContent
     * @return Response
     */
    public function downloadPdf(Submission $submission, string $htmlContent): Response
    {
        $fileName = $this->namingService->generateFileName($submission);
        $pdfBinary = $this->generatePdfBinary($htmlContent);

        return response($pdfBinary, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }

    /**
     * Generate direct inline PDF preview HTTP response for browser.
     *
     * @param Submission $submission
     * @param string $htmlContent
     * @return Response
     */
    public function streamPdf(Submission $submission, string $htmlContent): Response
    {
        $fileName = $this->namingService->generateFileName($submission);
        $pdfBinary = $this->generatePdfBinary($htmlContent);

        return response($pdfBinary, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $fileName . '"',
        ]);
    }

    /**
     * Prepare HTML content for Dompdf by embedding local CSS file and converting image URLs to base64.
     *
     * @param string $html
     * @return string
     */
    protected function prepareHtmlForDompdf(string $html): string
    {
        // 1. Embed local CSS with Dompdf body reset
        $cssPath = public_path('letter/letter-style.css');
        if (file_exists($cssPath)) {
            $cssContent = file_get_contents($cssPath);
            // Strip pre-existing @page rule from letter-style.css to ensure single @page declaration
            $cssContent = preg_replace('/@page\s*\{[^}]*\}/i', '', $cssContent);

            $pdfDompdfCss = "
                @page {
                    size: A4 portrait;
                    margin-top: 65pt;
                    margin-bottom: 0;
                    margin-left: 0;
                    margin-right: 0;
                }
                @page :first {
                    margin-top: 0;
                    margin-bottom: 0;
                    margin-left: 0;
                    margin-right: 0;
                }
                body {
                    background: #ffffff !important;
                    margin: 0 !important;
                    padding: 0 !important;
                }
                .sheet-wrap {
                    width: 595.28pt !important;
                    margin: 0 !important;
                    padding: 0 !important;
                    box-shadow: none !important;
                    background: #ffffff !important;
                }
                .page {
                    position: relative !important;
                    width: 595.28pt !important;
                    margin: 0 !important;
                    padding: 0 !important;
                    height: auto !important;
                    min-height: 0 !important;
                    background: #ffffff !important;
                }
                .letter-header {
                    position: absolute !important;
                    top: 20pt !important;
                    left: 72pt !important;
                    width: 471.28pt !important;
                    height: 65pt !important;
                }
                .logo-header {
                    position: absolute !important;
                    left: 0 !important;
                    top: 4pt !important;
                    width: 145pt !important;
                    height: 52pt !important;
                }
                .divider {
                    position: absolute !important;
                    left: 152pt !important;
                    top: 0 !important;
                    height: 64pt !important;
                    border-left: 1pt solid #7a6a94 !important;
                }
                .prodi-text {
                    position: absolute !important;
                    left: 160pt !important;
                    top: 0 !important;
                    width: 311.28pt !important;
                    font-size: 6.4pt !important;
                    line-height: 8.3pt !important;
                }
                .doc-content {
                    position: relative !important;
                    width: 471.28pt !important;
                    margin-left: 72pt !important;
                    margin-right: 52pt !important;
                    padding-top: 102pt !important;
                    padding-bottom: 70pt !important;
                }
                .letter-footer {
                    position: fixed !important;
                    bottom: 0 !important;
                    left: 0 !important;
                    width: 595.28pt !important;
                    height: 55pt !important;
                }
                .footer-badges {
                    position: absolute !important;
                    left: 72pt !important;
                    bottom: 14pt !important;
                    width: 140pt !important;
                    height: 38pt !important;
                }
                .footer-text {
                    position: absolute !important;
                    left: 240pt !important;
                    bottom: 14pt !important;
                    width: 303.28pt !important;
                }
                .colorbar-table {
                    position: absolute !important;
                    bottom: 0 !important;
                    left: 0 !important;
                    width: 595.28pt !important;
                    min-width: 595.28pt !important;
                }
            ";

            $inlineStyle = "<style>\n" . trim($cssContent) . "\n" . trim($pdfDompdfCss) . "\n</style>";
            $html = preg_replace('/<link[^>]*href="[^"]*letter-style\.css[^"]*"[^>]*>/i', $inlineStyle, $html);
        }

        // 2. Convert logo-amikom.png to base64 Data URI
        $logoPath = public_path('letter/logo-amikom.png');
        if (file_exists($logoPath)) {
            $base64Logo = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
            $html = preg_replace('/src="[^"]*letter\/logo-amikom\.png[^"]*"/i', 'src="' . $base64Logo . '"', $html);
        }

        // 3. Convert any remaining HTTP URLs pointing to local assets to base64 Data URIs
        $html = preg_replace_callback('/src="(https?:\/\/[^"]+)"/i', function ($matches) {
            $url = $matches[1];
            if (str_starts_with($url, 'data:')) {
                return $matches[0];
            }
            $parsedPath = parse_url($url, PHP_URL_PATH);
            if ($parsedPath) {
                $relativePath = ltrim($parsedPath, '/');
                $localPath = public_path($relativePath);
                if (file_exists($localPath)) {
                    $mime = mime_content_type($localPath) ?: 'image/png';
                    $base64 = base64_encode(file_get_contents($localPath));
                    return 'src="data:' . $mime . ';base64,' . $base64 . '"';
                }
            }
            return $matches[0];
        }, $html);

        // 4. Save final HTML to debug.html for verification
        @file_put_contents(base_path('debug.html'), $html);

        return $html;
    }
}
