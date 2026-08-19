<?php

namespace App\Services;

use App\Models\Submission;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\LaravelPdf\PdfBuilder;

class PdfGenerationService
{
    public function __construct(
        protected DocumentNamingService $namingService
    ) {}

    /**
     * Generate direct PDF download HTTP response for a submission.
     *
     * @return PdfBuilder
     */
    public function downloadPdf(Submission $submission, string $htmlContent)
    {
        $fileName = $this->namingService->generateFileName($submission);

        try {
            return Pdf::html($htmlContent)
                ->format('a4')
                ->withBrowsershot(function (Browsershot $browsershot) {
                    $this->configureBrowsershot($browsershot);
                })
                ->download($fileName);
        } catch (\Throwable $e) {
            report($e);
            abort(500, 'Gagal membuat PDF: '.$e->getMessage());
        }
    }

    /**
     * Generate direct inline PDF preview HTTP response for browser.
     *
     * @return PdfBuilder
     */
    public function streamPdf(Submission $submission, string $htmlContent)
    {
        $fileName = $this->namingService->generateFileName($submission);

        try {
            return Pdf::html($htmlContent)
                ->format('a4')
                ->withBrowsershot(function (Browsershot $browsershot) {
                    $this->configureBrowsershot($browsershot);
                })
                ->inline($fileName);
        } catch (\Throwable $e) {
            report($e);
            abort(500, 'Gagal membuat PDF: '.$e->getMessage());
        }
    }

    /**
     * Configure Browsershot/Chromium with Docker/ARM64-safe launch flags.
     *
     * The --disable-dev-shm-usage flag is critical inside containers where
     * /dev/shm is too small, which otherwise causes Chromium to hang or crash.
     */
    private function configureBrowsershot(Browsershot $browsershot): void
    {
        $browsershot->noSandbox();
        $browsershot->addChromiumArguments([
            '--disable-dev-shm-usage',
            '--disable-gpu',
            '--disable-setuid-sandbox',
            '--disable-extensions',
            '--disable-plugins',
            '--disable-software-rasterizer',
        ]);
        $browsershot->timeout(60);
    }
}
