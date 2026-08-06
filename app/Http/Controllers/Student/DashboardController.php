<?php

namespace App\Http\Controllers\Student;

use App\Enums\ApprovalRole;
use App\Enums\SubmissionStatus;
use App\Http\Controllers\Controller;
use App\Models\ApprovalFlowStep;
use App\Models\Submission;
use App\Models\User;
use App\Services\SubmissionAssignmentService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request, SubmissionAssignmentService $assignmentService)
    {
        $student = $request->user()->student;
        $nim = $student->student_number ?? '—';
        $prodi = 'D3 Teknik Informatika';

        $pendingCount = $student->submissions()
            ->where('status', SubmissionStatus::IN_REVIEW->value)
            ->count();

        $approvedCount = $student->submissions()
            ->where('status', SubmissionStatus::APPROVED->value)
            ->count();

        $rejectedCount = $student->submissions()
            ->where('status', SubmissionStatus::REJECTED->value)
            ->count();

        $latestSubmissions = $student->submissions()
            ->with([
                'letterType.approvalFlow.steps',
                'approvalFlowStep',
                'assignedToUser',
                'attachments',
            ])
            ->latest('created_at')
            ->take(5)
            ->get()
            ->map(function ($submission) use ($assignmentService) {
                $statusValue = $submission->status instanceof SubmissionStatus
                    ? $submission->status->value
                    : (string) $submission->status;

                $statusText = $this->resolveSubmissionStatusLabel($statusValue);

                $submittedAt = $submission->submitted_at ?? $submission->created_at;
                $submittedDate = $submittedAt?->translatedFormat('d M Y') ?? $submission->created_at?->translatedFormat('d M Y');
                $submittedTime = $submittedAt?->format('H:i') ?? $submission->created_at?->format('H:i');

                $attachments = $submission->attachments
                    ->map(function ($attachment) {
                        return [
                            'name' => $attachment->original_filename ?? $attachment->stored_filename ?? 'Lampiran.pdf',
                            'size' => $this->formatAttachmentSize((int) ($attachment->file_size ?? 0)),
                        ];
                    })
                    ->values()
                    ->all();

                if ($attachments === []) {
                    $attachments = [[
                        'name' => 'Lampiran.pdf',
                        'size' => 'Tidak ada file',
                    ]];
                }

                $flowSteps = $submission->letterType?->approvalFlow?->steps
                    ?->sortBy('step_order')
                    ->values()
                    ?? collect();

                $currentStepOrder = $submission->approvalFlowStep?->step_order ?? 0;
                $currentStepId = $submission->approvalFlowStep?->id;

                $timeline = $flowSteps->map(function ($step) use ($statusValue, $currentStepOrder, $currentStepId): array {
                    $stepStatus = 'pending';

                    if ($statusValue === SubmissionStatus::APPROVED->value) {
                        $stepStatus = 'completed';
                    } elseif ($step->id === $currentStepId) {
                        $stepStatus = 'active';
                    } elseif ($step->step_order < $currentStepOrder) {
                        $stepStatus = 'completed';
                    }

                    $label = $step->approval_role?->label() ?? $step->name;
                    $title = $label;

                    $time = match ($stepStatus) {
                        'completed' => 'Selesai',
                        'active' => 'Sedang diverifikasi',
                        default => 'Menunggu penugasan',
                    };

                    return [
                        'title' => $title,
                        'time' => $time,
                        'status' => $stepStatus,
                    ];
                })->values()->all();

                $lecturerStep = $flowSteps->first(function ($step) {
                    return $this->matchesApprovalRole($step->approval_role, ApprovalRole::ACADEMIC_ADVISOR);
                });
                $kaprodiStep = $flowSteps->first(function ($step) {
                    return $this->matchesApprovalRole($step->approval_role, ApprovalRole::HEAD_OF_STUDY_PROGRAM);
                });

                $lecturer = $this->resolveApproverName($submission, $lecturerStep, $assignmentService);
                $kaprodi = $this->resolveApproverName($submission, $kaprodiStep, $assignmentService);

                return [
                    'id' => $submission->id,
                    'type' => $submission->letterType?->name ?? 'Surat Akademik',
                    'date' => $submittedDate,
                    'status' => $statusValue,
                    'statusText' => $statusText,
                    'purpose' => $submission->purpose ?? 'Pengajuan dokumen akademik',
                    'lecturer' => $lecturer,
                    'kaprodi' => $kaprodi,
                    'time' => $submittedTime ? $submittedTime . ' WIB' : '00:00 WIB',
                    'attachments' => $attachments,
                    'timeline' => $timeline,
                ];
            })
            ->values();

        return view(
            'student.dashboard',
            compact(
                'student',
                'pendingCount',
                'approvedCount',
                'rejectedCount',
                'latestSubmissions',
                'nim',
                'prodi'
            )
        );
    }

    private function formatAttachmentSize(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $index = 0;

        while ($bytes >= 1024 && $index < count($units) - 1) {
            $bytes /= 1024;
            $index++;
        }

        return round($bytes, 1) . ' ' . $units[$index];
    }

    private function resolveApproverName(
        Submission $submission,
        ?ApprovalFlowStep $step,
        SubmissionAssignmentService $assignmentService
    ): string {

        if (! $step) {
            return 'Menunggu penetapan';
        }

        $userId = $assignmentService->resolveApprover(
            $submission,
            $step
        );

        if (! $userId) {
            return $step->name
                ?? $this->normalizeApprovalRole(
                    $step->approval_role
                )?->label()
                ?? 'Tahap persetujuan';
        }

        return User::query()
            ->whereKey($userId)
            ->value('name')
            ?? 'Menunggu penetapan';
    }

    private function resolveSubmissionStatusLabel(
        string|SubmissionStatus $status
    ): string {

        if ($status instanceof SubmissionStatus) {
            return $status->label();
        }

        return SubmissionStatus::tryFrom($status)?->label()
            ?? 'Sedang Diproses';
    }

    private function matchesApprovalRole(
        string|ApprovalRole|null $approvalRole,
        ApprovalRole $expectedRole
    ): bool {

        return $this->normalizeApprovalRole(
            $approvalRole
        ) === $expectedRole;
    }

    private function normalizeApprovalRole(
        string|ApprovalRole|null $approvalRole
    ): ?ApprovalRole {

        return match (true) {

            $approvalRole instanceof ApprovalRole
            => $approvalRole,

            is_string($approvalRole)
            => ApprovalRole::tryFrom($approvalRole),

            default
            => null,
        };
    }
}
