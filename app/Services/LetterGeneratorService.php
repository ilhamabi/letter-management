<?php

namespace App\Services;

use App\Models\GeneratedLetter;
use App\Models\Submission;

class LetterGeneratorService
{
    public function __construct(
        protected DocumentNamingService $namingService
    ) {}

    /**
     * Generate or retrieve official GeneratedLetter record with letter_number and qr_token upon final approval.
     *
     * @param Submission $submission
     * @return GeneratedLetter
     */
    public function generateLetterForSubmission(Submission $submission): GeneratedLetter
    {
        $submission->loadMissing([
            'letterType',
            'student.user',
            'logs' => function ($q) {
                $q->with(['user', 'approvalFlowStep'])->latest();
            },
        ]);

        $letterCode = $submission->letterType ? strtoupper($submission->letterType->code) : 'SK';
        $romanMonth = $this->getRomanMonth((int) date('n'));
        $year = date('Y');

        $letterNumber = sprintf('%s-%03d/AMIKOM/%s/%s', $letterCode, $submission->id, $romanMonth, $year);
        $qrToken = sprintf('VERIFY-%s-%04d-%s', $letterCode, $submission->id, strtoupper(\Illuminate\Support\Str::random(8)));
        $filePath = $this->namingService->generateFilePath($submission);

        $generatedLetter = GeneratedLetter::updateOrCreate(
            ['submission_id' => $submission->id],
            [
                'letter_number' => $letterNumber,
                'file_path' => $filePath,
                'qr_token' => $qrToken,
                'generated_at' => now(),
            ]
        );

        return $generatedLetter;
    }

    /**
     * Extract structured signers context array from approved submission logs.
     * Supports both single signer and multi-signer workflows.
     *
     * @param Submission $submission
     * @return array
     */
    public function extractSignersContext(Submission $submission): array
    {
        $submission->loadMissing(['logs.user', 'logs.approvalFlowStep', 'student.user']);

        $studentUserId = $submission->student?->user_id;

        // Filter valid lecturer approval logs (ignore initial student creation log)
        $approvedLogs = $submission->logs
            ->filter(function ($l) use ($studentUserId) {
                $statusStr = strtolower(is_object($l->status) ? $l->status->value : (string) $l->status);
                if ($statusStr !== 'approved') {
                    return false;
                }
                if (is_null($l->approval_flow_step_id)) {
                    return false;
                }
                if ($studentUserId && $l->user_id === $studentUserId) {
                    return false;
                }
                return true;
            })
            ->sortBy('created_at')
            ->values();

        if ($approvedLogs->isEmpty()) {
            return [
                [
                    'title' => 'Ketua Program Studi',
                    'department' => 'Prodi D3 Teknik Informatika',
                    'name' => 'Dr. Barka Satya, M.Kom',
                    'nip' => '190302126',
                    'city' => 'Yogyakarta',
                    'date' => $this->formatIndonesianDate(now()),
                ],
            ];
        }

        // Deduplicate logs by user_id so a lecturer who approves multiple steps appears only once
        $uniqueUserLogs = collect();
        foreach ($approvedLogs as $log) {
            $key = $log->user_id ?? ('log_' . $log->id);
            $uniqueUserLogs->put($key, $log);
        }

        $signers = [];
        foreach ($uniqueUserLogs as $log) {
            $title = 'Pejabat Berwenang';
            if ($log->approvalFlowStep) {
                $title = $log->approvalFlowStep->name;
                if (method_exists($log->approvalFlowStep->approval_role, 'label')) {
                    $title = $log->approvalFlowStep->approval_role->label();
                }
            }

            $signers[] = [
                'title' => $title,
                'department' => 'Universitas AMIKOM Yogyakarta',
                'name' => $log->user ? $log->user->name : 'Sistem Kampus',
                'nip' => $log->user ? ($log->user->nip ?? $log->user->username ?? '-') : '-',
                'city' => 'Yogyakarta',
                'date' => $this->formatIndonesianDate($log->created_at ?? now()),
            ];
        }

        return $signers;
    }

    /**
     * Format a date string or DateTime object into Indonesian long date format (e.g., 14 Agustus 2026).
     */
    public function formatIndonesianDate($value): string
    {
        if (empty($value)) {
            return '-';
        }

        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        try {
            $date = null;
            if ($value instanceof \DateTimeInterface) {
                $date = \Carbon\Carbon::instance($value);
            } elseif (is_string($value)) {
                $date = \Carbon\Carbon::parse($value);
            }

            if ($date) {
                $day = $date->format('j');
                $month = $months[(int)$date->format('n')];
                $year = $date->format('Y');
                return "{$day} {$month} {$year}";
            }
        } catch (\Throwable $e) {
            return (string) $value;
        }

        return (string) $value;
    }

    /**
     * Convert integer month to Roman numeral string.
     */
    protected function getRomanMonth(int $month): string
    {
        $map = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];

        return $map[$month] ?? 'I';
    }
}
