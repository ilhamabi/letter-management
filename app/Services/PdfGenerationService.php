<?php

namespace App\Services;

use App\Models\Submission;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\Browsershot\Browsershot;

class PdfGenerationService
{
    public function __construct(
        protected DocumentNamingService $namingService
    ) {}

    /**
     * Generate direct PDF download HTTP response for a submission.
     *
     * @param Submission $submission
     * @param string $htmlContent
     * @return \Spatie\LaravelPdf\PdfBuilder
     */
    public function downloadPdf(Submission $submission, string $htmlContent)
    {
        $fileName = $this->namingService->generateFileName($submission);
        
        return Pdf::html($htmlContent)
            ->format('a4')
            ->withBrowsershot(function (Browsershot $browsershot) {
                $browsershot->noSandbox();
            })
            ->download($fileName);
    }

    /**
     * Generate direct inline PDF preview HTTP response for browser.
     *
     * @param Submission $submission
     * @param string $htmlContent
     * @return \Spatie\LaravelPdf\PdfBuilder
     */
    public function streamPdf(Submission $submission, string $htmlContent)
    {
        $fileName = $this->namingService->generateFileName($submission);
        
        return Pdf::html($htmlContent)
            ->format('a4')
            ->withBrowsershot(function (Browsershot $browsershot) {
                $browsershot->noSandbox();
            })
            ->inline($fileName);
    }
}
