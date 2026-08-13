<?php

namespace App\Services;

use App\Models\Submission;

class DocumentNamingService
{
    /**
     * Generate standard official filename for a submission's PDF letter.
     * Example: Surat_SR-PENELITIAN_20210001.pdf or Surat_SR-MAGANG_20210002.pdf
     *
     * @param Submission $submission
     * @return string
     */
    public function generateFileName(Submission $submission): string
    {
        $letterCode = $submission->letterType ? strtoupper($submission->letterType->code) : 'SURAT';
        $letterCodeClean = preg_replace('/[^A-Z0-9\-]/', '', $letterCode);
        
        $nim = $submission->student?->student_number ?? ('ID_' . $submission->id);
        $sanitizedNim = preg_replace('/[^A-Za-z0-9]/', '', (string) $nim);

        return sprintf('Surat_%s_%s.pdf', $letterCodeClean, $sanitizedNim);
    }

    /**
     * Generate storage relative file path for storing the PDF on disk.
     * Example: letters/surat_sr-penelitian_20210001.pdf
     *
     * @param Submission $submission
     * @return string
     */
    public function generateFilePath(Submission $submission): string
    {
        return 'letters/' . strtolower($this->generateFileName($submission));
    }
}
