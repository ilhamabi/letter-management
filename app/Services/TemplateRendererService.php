<?php

namespace App\Services;

class TemplateRendererService
{
    public function __construct(
        protected BodyTemplateRendererService $bodyRenderer
    ) {}

    /**
     * Render body content.
     */
    public function render(string $templateHtml, array $contextData = []): string
    {
        return $this->bodyRenderer->render($templateHtml, $contextData);
    }

    /**
     * Render full document view for Admin Template Preview mode.
     */
    public function renderAdminPreview(string $bodyHtml, string $documentTitle = 'Preview Template Surat (Mode Admin)')
    {
        $renderedBody = $this->bodyRenderer->render($bodyHtml, []);

        return view('letter.preview', [
            'bodyContent' => $renderedBody,
            'isPlaceholderMode' => true,
            'documentTitle' => $documentTitle,
        ]);
    }

    /**
     * Render full document view for actual generated letter or submission.
     */
    public function renderFullDocumentView(
        string $bodyHtml, 
        array $contextData = [], 
        array $signatureProps = [], 
        string $documentTitle = 'Surat Resmi - Universitas AMIKOM Yogyakarta',
        ?array $signers = null,
        ?string $qrToken = null,
        ?string $customCss = null
    ) {
        $renderedBody = $this->bodyRenderer->render($bodyHtml, $contextData);

        return view('letter.preview', [
            'bodyContent' => $renderedBody,
            'isPlaceholderMode' => false,
            'signers' => $signers,
            'qrToken' => $qrToken ?? 'VERIFY-TOKEN-2026',
            'documentTitle' => $documentTitle,
            'customCss' => $customCss,
        ]);
    }
}
