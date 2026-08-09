<?php

namespace App\Services;

use App\Enums\ApprovalRole;
use App\Enums\SubmissionLogStatus;
use App\Enums\SubmissionStatus;
use App\Models\LecturerPosition;
use App\Models\StudentLecturer;
use App\Models\Submission;
use App\Models\User;

class StudentDashboardService
{
    /**
     * Retrieve aggregated dashboard data for a student user.
     */
    public function getDashboardData(User $user): array
    {
        $student = $user->student;
        $nim = $student?->student_number ?? $user->username ?? '—';
        $prodi = 'D3 Teknik Informatika';

        if (!$student) {
            return [
                'student' => null,
                'nim' => $nim,
                'prodi' => $prodi,
                'pendingCount' => 0,
                'approvedCount' => 0,
                'rejectedCount' => 0,
                'latestSubmissions' => collect(),
            ];
        }

        // Base Query for Submissions (Owned or Joined as Group Member)
        $accessibleSubmissionsQuery = function () use ($student) {
            return Submission::query()->where(function ($q) use ($student) {
                $q->where('student_id', $student->id)
                    ->orWhereHas('groupMembers', function ($g) use ($student) {
                        $g->where('student_id', $student->id);
                    });
            });
        };

        // Calculate summary statistics
        $pendingCount = $accessibleSubmissionsQuery()
            ->whereIn('status', [SubmissionStatus::PENDING->value, SubmissionStatus::IN_REVIEW->value])
            ->count();

        $approvedCount = $accessibleSubmissionsQuery()
            ->whereIn('status', [SubmissionStatus::APPROVED->value, SubmissionStatus::GENERATED->value])
            ->count();

        $rejectedCount = $accessibleSubmissionsQuery()
            ->where('status', SubmissionStatus::REJECTED->value)
            ->count();

        // Eager load latest 5 submissions with relationships to avoid N+1 queries
        $latestSubmissions = $accessibleSubmissionsQuery()
            ->with([
                'student.user',
                'letterType.approvalFlow.steps',
                'approvalFlowStep',
                'assignedToUser',
                'attachments',
                'logs.approvalFlowStep',
                'logs.user',
                'groupMembers.student.user',
            ])
            ->latest('created_at')
            ->take(5)
            ->get()
            ->map(function ($submission) {
                return $this->formatSubmissionDto($submission);
            })
            ->values();

        return [
            'student' => $student,
            'nim' => $nim,
            'prodi' => $prodi,
            'pendingCount' => $pendingCount,
            'approvedCount' => $approvedCount,
            'rejectedCount' => $rejectedCount,
            'latestSubmissions' => $latestSubmissions,
        ];
    }

    /**
     * Format a submission instance into a clean DTO array for UI consumption.
     */
    public function formatSubmissionDto($submission): array
    {
        $statusValue = is_object($submission->status) ? $submission->status->value : (string) $submission->status;
        $statusEnum = $submission->status instanceof SubmissionStatus
            ? $submission->status
            : SubmissionStatus::tryFrom($statusValue);

        $statusText = $statusEnum?->label() ?? $statusValue;
        if ($statusEnum === SubmissionStatus::IN_REVIEW && $submission->approvalFlowStep) {
            $roleLabel = $submission->approvalFlowStep->approval_role?->label() ?? $submission->approvalFlowStep->name;
            $statusText = "Menunggu Persetujuan {$roleLabel}";
        }
        $statusBadgeClass = $statusEnum?->badgeClass() ?? 'bg-gray-100 text-gray-700 border-gray-200';

        $submittedAt = $this->parseCarbonDate($submission->submitted_at ?? $submission->created_at);
        $submittedDate = $submittedAt?->translatedFormat('d M Y') ?? '-';
        $submittedTime = $submittedAt?->format('H:i') ?? '00:00';

        $isGroup = (bool) ($submission->letterType?->allow_group_submission || $submission->groupMembers->isNotEmpty());
        $creatorName = $submission->student?->user?->name ?? 'Mahasiswa';
        $creatorNim = $submission->student?->student_number ?? '-';

        $members = $submission->groupMembers->map(function ($member) {
            return [
                'nim' => $member->student?->student_number ?? '-',
                'name' => $member->student?->user?->name ?? 'Anggota Tim',
            ];
        })->values()->all();

        $attachments = $submission->attachments
            ->map(function ($attachment) {
                return [
                    'id' => $attachment->id,
                    'name' => $attachment->original_filename ?? $attachment->stored_filename ?? 'Lampiran.pdf',
                    'size' => $this->formatAttachmentSize((int) ($attachment->file_size ?? 0)),
                    'url' => asset('storage/' . $attachment->file_path),
                ];
            })
            ->values()
            ->all();

        $timeline = $this->buildTimeline($submission);

        $academicAdvisorName = 'Dosen Wali';
        $kaprodiName = 'Kaprodi';
        if ($submission->student) {
            $advisor = StudentLecturer::query()
                ->where('student_id', $submission->student->id)
                ->where('lecturer_role', ApprovalRole::ACADEMIC_ADVISOR->value)
                ->where('is_active', true)
                ->with('lecturer.user')
                ->first()?->lecturer;
            if ($advisor?->user?->name) {
                $academicAdvisorName = $advisor->user->name;
            }

            $kaprodi = LecturerPosition::query()
                ->where('position', ApprovalRole::HEAD_OF_STUDY_PROGRAM->value)
                ->where('is_active', true)
                ->with('lecturer.user')
                ->first()?->lecturer;
            if ($kaprodi?->user?->name) {
                $kaprodiName = $kaprodi->user->name;
            }
        }

        $studentProdi = $submission->student?->study_program ?? 'D3 Teknik Informatika';
        $studentNim = $submission->student?->student_number ?? $creatorNim ?? '-';

        return [
            'id' => $submission->id,
            'number' => 'SUB-' . str_pad($submission->id, 5, '0', STR_PAD_LEFT),
            'type' => $submission->letterType?->name ?? 'Surat Akademik',
            'date' => $submittedDate,
            'status' => $statusValue,
            'statusText' => $statusText,
            'statusBadgeClass' => $statusBadgeClass,
            'isGroup' => $isGroup,
            'creatorName' => $creatorName,
            'creatorNim' => $creatorNim,
            'nim' => $studentNim,
            'prodi' => $studentProdi,
            'members' => $members,
            'purpose' => $submission->purpose ?? 'Pengajuan dokumen akademik',
            'lecturer' => $academicAdvisorName,
            'kaprodi' => $kaprodiName,
            'time' => $submittedTime . ' WIB',
            'attachments' => $attachments,
            'timeline' => $timeline,
        ];
    }

    /**
     * Build the chronological timeline of steps and actions for a submission.
     */
    public function buildTimeline($submission): array
    {
        $flowSteps = $submission->letterType?->approvalFlow?->steps
                ?->sortBy('step_order')
            ->values()
            ?? collect();

        $logs = $submission->logs->keyBy('approval_flow_step_id');
        $currentStepId = $submission->approval_flow_step_id;
        $submissionStatus = $submission->status instanceof SubmissionStatus
            ? $submission->status
            : SubmissionStatus::tryFrom($submission->status);

        $timeline = [];

        // Initial Step: Submission Created Log
        $initialLog = $submission->logs->whereNull('approval_flow_step_id')->first();
        $initTime = $this->parseCarbonDate($initialLog?->created_at ?? $submission->submitted_at ?? $submission->created_at);
        $initNotes = $initialLog?->notes ?? 'Permohonan berhasil dikirim oleh mahasiswa.';

        $timeline[] = [
            'title' => 'Pengajuan Dibuat',
            'time' => $initTime ? $initTime->translatedFormat('d M Y H:i') . ' WIB' : 'Selesai',
            'status' => 'completed',
            'notes' => $initNotes,
        ];

        if ($flowSteps->isEmpty()) {
            return $timeline;
        }

        $reachedCurrent = false;

        foreach ($flowSteps as $step) {
            $log = $logs->get($step->id);
            $roleLabel = $step->approval_role?->label() ?? $step->name;
            $title = "Persetujuan {$roleLabel}";

            if ($log) {
                $logStatusObj = $log->status instanceof SubmissionLogStatus
                    ? $log->status
                    : SubmissionLogStatus::tryFrom((string) $log->status);

                $isApproved = $logStatusObj === SubmissionLogStatus::APPROVED;
                $isRejected = $logStatusObj === SubmissionLogStatus::REJECTED;

                $stepStatus = $isApproved ? 'completed' : ($isRejected ? 'rejected' : 'active');
                $logCreatedAt = $this->parseCarbonDate($log->created_at);
                $timeText = $logCreatedAt ? $logCreatedAt->translatedFormat('d M Y H:i') . ' WIB' : 'Selesai';
                if ($log->user) {
                    $statusLabel = $logStatusObj?->label() ?? 'Diproses';
                    $timeText .= " ({$log->user->name} - {$statusLabel})";
                }

                $timeline[] = [
                    'title' => $title,
                    'time' => $timeText,
                    'status' => $stepStatus,
                    'notes' => $log->notes,
                ];
            } else {
                if ($submissionStatus === SubmissionStatus::APPROVED || $submissionStatus === SubmissionStatus::GENERATED) {
                    $stepStatus = 'completed';
                    $timeText = 'Selesai';
                } elseif ($submissionStatus === SubmissionStatus::REJECTED) {
                    $stepStatus = 'pending';
                    $timeText = 'Dibatalkan';
                } elseif ($step->id === $currentStepId || (!$reachedCurrent && $submission->approval_flow_step_id === null)) {
                    $stepStatus = 'active';
                    $timeText = 'Sedang diverifikasi';
                    $reachedCurrent = true;
                } elseif ($reachedCurrent) {
                    $stepStatus = 'pending';
                    $timeText = 'Menunggu giliran';
                } else {
                    $stepStatus = 'completed';
                    $timeText = 'Selesai';
                }

                $timeline[] = [
                    'title' => $title,
                    'time' => $timeText,
                    'status' => $stepStatus,
                    'notes' => null,
                ];
            }
        }

        return $timeline;
    }

    /**
     * Format raw byte count into human-readable file size strings.
     */
    private function formatAttachmentSize(int $bytes): string
    {
        if ($bytes <= 0) {
            return '0 B';
        }

        $units = ['B', 'KB', 'MB', 'GB'];
        $index = 0;

        while ($bytes >= 1024 && $index < count($units) - 1) {
            $bytes /= 1024;
            $index++;
        }

        return round($bytes, 1) . ' ' . $units[$index];
    }

    /**
     * Safely parse carbon date instances from heterogeneous inputs.
     */
    private function parseCarbonDate($date): ?\Illuminate\Support\Carbon
    {
        if (empty($date)) {
            return null;
        }

        if ($date instanceof \Illuminate\Support\Carbon || $date instanceof \DateTimeInterface) {
            return \Illuminate\Support\Carbon::instance($date);
        }

        try {
            return \Illuminate\Support\Carbon::parse($date);
        } catch (\Throwable $e) {
            return null;
        }
    }
}
