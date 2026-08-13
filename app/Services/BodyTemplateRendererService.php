<?php

namespace App\Services;

class BodyTemplateRendererService
{
    public function __construct(
        protected PlaceholderProviderService $placeholderProvider
    ) {}

    /**
     * Render body content template by replacing all placeholder variables with actual submission/student data.
     *
     * @param string $templateHtml
     * @param array $contextData
     * @return string
     */
    public function render(string $templateHtml, array $contextData = []): string
    {
        if (empty($templateHtml)) {
            return '';
        }

        // 1. Unwrap any TinyMCE placeholder pill span elements back into clean raw {{KEY}} tokens first
        // Example: <span class="placeholder-pill" contenteditable="false">{{student_name}}</span> -> {{student_name}}
        $content = preg_replace(
            '/<span\b[^>]*class="[^"]*placeholder-pill[^"]*"[^>]*>\s*(\{\{[^}]+\}\})\s*<\/span>/i',
            '$1',
            $templateHtml
        );

        $mappings = $this->buildMapping($contextData);

        // 2. Perform exact string replacement for each placeholder key and alias
        foreach ($mappings as $key => $val) {
            $content = str_replace($key, (string)$val, $content);
        }

        return $content;
    }

    /**
     * Map context data or fallbacks to placeholder keys and aliases.
     *
     * @param array $data
     * @return array
     */
    protected function buildMapping(array $data): array
    {
        $defaultSamples = $this->placeholderProvider->getSampleData();
        $mapping = [];
        $additionalData = is_array($data['additional_data'] ?? null) ? $data['additional_data'] : [];

        foreach ($this->placeholderProvider->getGroupedPlaceholders() as $group) {
            foreach ($group['items'] as $item) {
                $primaryKey = $item['key'];
                $rawProp = str_replace(['{{', '}}'], '', $primaryKey);

                $isAdminPreview = !empty($data['is_admin_preview']);

                $resolvedVal = $data[$rawProp] 
                    ?? $additionalData[$rawProp]
                    ?? $data[$item['label']] 
                    ?? $additionalData[$item['label']]
                    ?? ($isAdminPreview ? ($defaultSamples[$primaryKey] ?? '') : '');

                $mapping[$primaryKey] = $resolvedVal;
                foreach ($item['aliases'] as $alias) {
                    $mapping[$alias] = $resolvedVal;
                }
            }
        }

        return $mapping;
    }
}
