<?php

namespace App\Services;

use App\Enums\ApprovalRole;
use App\Enums\SubmissionLogStatus;
use App\Enums\SubmissionStatus;
use App\Models\ApprovalFlowStep;
use App\Models\Student;
use App\Models\Submission;
use App\Models\SubmissionLog;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class LecturerSubmissionService
{
    public function __construct(
        protected ApprovalWorkflowService $workflowService,
        protected StudentDashboardService $studentDashboardService,
        protected DocumentNamingService $namingService,
        protected TemplateRendererService $templateRenderer,
        protected LetterGeneratorService $letterGeneratorService
    ) {}

    /**
     * Retrieve aggregated dashboard statistics and recent pending submissions for lecturer.
     */
    public function getDashboardData(User $user): array
    {
        $userId = $user->id;
        $pendingCount = $this->getPendingCount($userId);
        $processedCount = $this->getProcessedCount($userId);
        $totalCount = $pendingCount + $processedCount;
        $percentageProcessed = $totalCount > 0 ? round(($processedCount / $totalCount) * 100) : 0;

        return [
            'lecturer' => $user->lecturer,
            'lecturerName' => $user->name,
            'pendingCount' => $pendingCount,
            'processedCount' => $processedCount,
            'totalCount' => $totalCount,
            'percentageProcessed' => $percentageProcessed,
            'latestSubmissions' => $this->getLatestPendingSubmissions($userId),
        ];
    }

    /**
     * Count pending submissions assigned to lecturer requiring action.
     */
    protected function getPendingCount(int $userId): int
    {
        return Submission::query()
            ->where('assigned_to_user_id', $userId)
            ->where('status', SubmissionStatus::IN_REVIEW)
            ->count();
    }

    /**
     * Count processed submissions by lecturer.
     */
    protected function getProcessedCount(int $userId): int
    {
        return Submission::query()
            ->whereHas('logs', fn($q) => $q->where('user_id', $userId))
            ->where(function ($q) use ($userId) {
                $q->where('assigned_to_user_id', '!=', $userId)
                  ->orWhere('status', '!=', SubmissionStatus::IN_REVIEW->value);
            })
            ->distinct()
            ->count();
    }

    /**
     * Fetch top 5 latest pending submissions assigned to lecturer.
     */
    protected function getLatestPendingSubmissions(int $userId): Collection
    {
        return Submission::query()
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
            ->where('assigned_to_user_id', $userId)
            ->where('status', SubmissionStatus::IN_REVIEW)
            ->latest('submitted_at')
            ->take(5)
            ->get();
    }

    /**
     * Retrieve paginated approval list for submissions currently assigned to lecturer.
     */
    public function getApprovalListData(User $user, array $filters): array
    {
        $userId = $user->id;

        $query = Submission::query()
            ->where('assigned_to_user_id', $userId)
            ->where('status', SubmissionStatus::IN_REVIEW)
            ->with([
                'student.user',
                'letterType.approvalFlow.steps',
                'approvalFlowStep',
                'assignedToUser',
                'attachments',
                'logs.approvalFlowStep',
                'logs.user',
                'groupMembers.student.user',
            ]);

        // Filter by student name or NIM
        if (!empty($filters['search'])) {
            $search = strtolower((string) $filters['search']);
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('student_number', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%"));
            });
        }

        // Filter by letter type
        if (!empty($filters['letter_type_id'])) {
            $query->where('letter_type_id', $filters['letter_type_id']);
        }

        // Filter by lecturer role
        if (!empty($filters['role'])) {
            $roleInput = $filters['role'];
            $query->whereHas('approvalFlowStep', function ($q) use ($roleInput) {
                $q->where('approval_role', $roleInput)
                  ->orWhere('name', 'like', "%{$roleInput}%");
            });
        }

        // Filter by batch angkatan
        if (!empty($filters['batch'])) {
            $batch = $filters['batch'];
            $query->whereHas('student', function ($q) use ($batch) {
                $shortYear = substr($batch, -2);
                $q->where('batch_year', $batch)
                  ->orWhere('student_number', 'like', "{$shortYear}.%");
            });
        }

        // Sort order
        $sortOrder = ($filters['sort'] ?? 'newest') === 'oldest' ? 'asc' : 'desc';
        $submissions = $query->orderBy('submitted_at', $sortOrder)
            ->paginate(10)
            ->withQueryString();

        return compact('submissions');
    }

    /**
     * Retrieve paginated submission history processed by this lecturer.
     */
    public function getHistoryData(User $user, array $filters): array
    {
        $userId = $user->id;

        $query = Submission::query()
            ->whereHas('logs', fn($q) => $q->where('user_id', $userId))
            ->with([
                'student.user',
                'letterType.approvalFlow.steps',
                'approvalFlowStep',
                'assignedToUser',
                'attachments',
                'logs.approvalFlowStep',
                'logs.user',
                'groupMembers.student.user',
            ]);

        // Filter by student name or NIM
        if (!empty($filters['search'])) {
            $search = strtolower((string) $filters['search']);
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('student_number', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%"));
            });
        }

        // Filter by letter type
        if (!empty($filters['letter_type_id'])) {
            $query->where('letter_type_id', $filters['letter_type_id']);
        }

        // Filter by status
        if (!empty($filters['status'])) {
            $statusInput = strtolower((string) $filters['status']);
            if (in_array($statusInput, ['disetujui', 'approved'])) {
                $query->whereIn('status', [SubmissionStatus::APPROVED->value, SubmissionStatus::GENERATED->value]);
            } elseif (in_array($statusInput, ['ditolak', 'rejected'])) {
                $query->where('status', SubmissionStatus::REJECTED->value);
            } elseif (in_array($statusInput, ['diproses', 'in_review', 'diteruskan'])) {
                $query->whereIn('status', [SubmissionStatus::PENDING->value, SubmissionStatus::IN_REVIEW->value]);
            }
        }

        // Filter by role
        if (!empty($filters['role'])) {
            $roleInput = $filters['role'];
            $query->whereHas('logs.approvalFlowStep', function ($q) use ($roleInput) {
                $q->where('approval_role', $roleInput)
                  ->orWhere('name', 'like', "%{$roleInput}%");
            });
        }

        // Filter by batch angkatan
        if (!empty($filters['batch'])) {
            $batch = $filters['batch'];
            $query->whereHas('student', function ($q) use ($batch) {
                $shortYear = substr($batch, -2);
                $q->where('batch_year', $batch)
                  ->orWhere('student_number', 'like', "{$shortYear}.%");
            });
        }

        // Filter by approval date range (kapan dosen melakukan persetujuan)
        if (!empty($filters['approval_from'])) {
            $from = $filters['approval_from'];
            $query->whereHas('logs', function ($q) use ($userId, $from) {
                $q->where('user_id', $userId)
                  ->whereDate('created_at', '>=', $from);
            });
        }

        if (!empty($filters['approval_to'])) {
            $to = $filters['approval_to'];
            $query->whereHas('logs', function ($q) use ($userId, $to) {
                $q->where('user_id', $userId)
                  ->whereDate('created_at', '<=', $to);
            });
        }

        $sortOrder = ($filters['sort'] ?? 'newest') === 'oldest' ? 'asc' : 'desc';
        $submissions = $query->orderBy('submitted_at', $sortOrder)
            ->paginate(10)
            ->withQueryString();

        return compact('submissions');
    }

    /**
     * Retrieve distinct student batch years present in database, ordered newest to oldest.
     *
     * @return array List of batch strings e.g. ['2026', '2025', '2023', '2021']
     */
    public function getAvailableBatches(): array
    {
        $students = Student::query()
            ->where(function ($q) {
                $q->whereNotNull('batch_year')
                  ->orWhereNotNull('student_number');
            })
            ->get(['batch_year', 'student_number']);

        return $students->map(function ($s) {
            if (!empty($s->batch_year)) {
                return (string) $s->batch_year;
            }
            if (!empty($s->student_number)) {
                if (str_starts_with($s->student_number, '20')) {
                    return substr($s->student_number, 0, 4);
                }
                return '20' . substr($s->student_number, 0, 2);
            }
            return null;
        })
        ->filter(fn($b) => !empty($b) && is_numeric($b) && (int)$b >= 2000 && (int)$b <= 2099)
        ->unique()
        ->sortDesc()
        ->values()
        ->toArray();
    }

    /**
     * Retrieve dynamic filter dropdown options based on database and user roles.
     */
    public function getFilterOptions(User $user): array
    {
        $letterTypes = \App\Models\LetterType::where('is_active', true)->orderBy('name')->get();
        $letterTypeOptions = [['value' => '', 'label' => 'Semua Jenis Surat']];
        foreach ($letterTypes as $lt) {
            $letterTypeOptions[] = [
                'value' => (string) $lt->id,
                'label' => $lt->name,
            ];
        }

        $lecturerRoles = $user->lecturer?->getActiveRoles() ?? [];
        $roleOptions = [['value' => '', 'label' => 'Semua Peran']];
        foreach ($lecturerRoles as $r) {
            $roleOptions[] = [
                'value' => $r['code'],
                'label' => $r['name'],
            ];
        }

        $batches = $this->getAvailableBatches();
        $batchOptions = [['value' => '', 'label' => 'Semua Angkatan']];
        foreach ($batches as $b) {
            $batchOptions[] = [
                'value' => (string) $b,
                'label' => 'Angkatan ' . $b,
            ];
        }

        $statusOptions = [
            ['value' => '', 'label' => 'Semua Status'],
            ['value' => 'diproses', 'label' => 'Diproses'],
            ['value' => 'disetujui', 'label' => 'Disetujui'],
            ['value' => 'ditolak', 'label' => 'Ditolak'],
        ];

        $sortOptions = [
            ['value' => 'newest', 'label' => 'Terbaru (Newest First)'],
            ['value' => 'oldest', 'label' => 'Terlama (Oldest First)'],
        ];

        return compact(
            'letterTypes',
            'letterTypeOptions',
            'lecturerRoles',
            'roleOptions',
            'batches',
            'batchOptions',
            'statusOptions',
            'sortOptions'
        );
    }

    /**
     * Get detailed formatted view data for a specific submission.
     */
    public function getSubmissionDetailData(User $user, Submission $submission): array
    {
        $submission->loadMissing([
            'student.user',
            'letterType.activeTemplate',
            'letterType.approvalFlow.steps',
            'approvalFlowStep',
            'assignedToUser',
            'attachments',
            'logs.approvalFlowStep',
            'logs.user',
            'groupMembers.student.user',
            'generatedLetter',
        ]);

        $subDto = $this->studentDashboardService->formatSubmissionDto($submission);

        // Fetch workflow step approver roles & assignees
        $workflowSteps = $submission->letterType?->approvalFlow?->steps?->sortBy('step_order')->values() ?? collect();
        $formattedSteps = [];
        $assignmentService = app(SubmissionAssignmentService::class);

        foreach ($workflowSteps as $index => $step) {
            $isAssignedToCurrentLecturer = false;
            $approverName = 'Belum Ditentukan';
            $isCompleted = false;
            $isCurrent = ($step->id === $submission->approval_flow_step_id && $submission->status === SubmissionStatus::IN_REVIEW);

            // Check if step log exists (has been processed)
            $log = $submission->logs->where('approval_flow_step_id', $step->id)->first();
            if ($log && $log->user) {
                $approverName = $log->user->name;
                $isCompleted = true;
                if ($log->user_id === $user->id) {
                    $isAssignedToCurrentLecturer = true;
                }
            } elseif ($isCurrent) {
                if ($submission->assignedToUser) {
                    $approverName = $submission->assignedToUser->name;
                    if ($submission->assigned_to_user_id === $user->id) {
                        $isAssignedToCurrentLecturer = true;
                    }
                }
            } else {
                // Future step or unreached step: resolve target approver
                try {
                    $targetUserId = $assignmentService->resolveApprover($submission, $step);
                    $targetUser = User::find($targetUserId);
                    if ($targetUser) {
                        $approverName = $targetUser->name;
                        if ($targetUserId === $user->id) {
                            $isAssignedToCurrentLecturer = true;
                        }
                    }
                } catch (\Throwable $e) {
                    $approverName = 'Dosen Verifikator';
                }
            }

            $formattedSteps[] = [
                'id' => $step->id,
                'step_order' => $step->step_order ?? ($index + 1),
                'role' => $step->approval_role?->label() ?? $step->name,
                'role_code' => $step->approval_role?->value ?? 'ROLE',
                'approver_name' => $approverName,
                'is_current' => $isCurrent,
                'is_completed' => $isCompleted,
                'is_assigned_to_me' => $isAssignedToCurrentLecturer,
            ];
        }

        // Determine if logged-in lecturer has consecutive approval steps
        $consecutiveStepIds = $this->detectConsecutiveStepsForUser($submission, $user);

        // Render actual HTML document preview using LetterPreviewService for 100% consistent context data binding
        $letterPreviewService = app(LetterPreviewService::class);
        $previewView = $letterPreviewService->renderSubmissionView($submission, [], true);

        $previewHtml = $previewView->render();
        $previewFileName = $this->namingService->generateFileName($submission);

        return [
            'submission' => $submission,
            'subDto' => $subDto,
            'formattedSteps' => $formattedSteps,
            'consecutiveStepIds' => $consecutiveStepIds,
            'canApprove' => $submission->assigned_to_user_id === $user->id && $submission->status === SubmissionStatus::IN_REVIEW,
            'previewHtml' => $previewHtml,
            'previewFileName' => $previewFileName,
        ];
    }

    /**
     * Detect if consecutive approval steps belong to the logged-in lecturer.
     */
    protected function detectConsecutiveStepsForUser(Submission $submission, User $user): array
    {
        $flowSteps = $submission->letterType?->approvalFlow?->steps?->sortBy('step_order')->values() ?? collect();
        $consecutiveStepIds = [];

        $currentStep = $submission->approvalFlowStep;
        if (!$currentStep || $submission->assigned_to_user_id !== $user->id) {
            return $consecutiveStepIds;
        }

        $consecutiveStepIds[] = $currentStep->id;

        // Check subsequent steps
        $currentIndex = $flowSteps->search(fn($s) => $s->id === $currentStep->id);
        if ($currentIndex !== false) {
            for ($i = $currentIndex + 1; $i < $flowSteps->count(); $i++) {
                $nextStep = $flowSteps[$i];
                $nextApproverUserId = app(SubmissionAssignmentService::class)->resolveApprover($submission, $nextStep);

                if ($nextApproverUserId === $user->id) {
                    $consecutiveStepIds[] = $nextStep->id;
                } else {
                    break;
                }
            }
        }

        return $consecutiveStepIds;
    }

    /**
     * Approve submission step(s) for lecturer.
     * Respects requested $stepsToApprove count (default 1, up to max consecutive steps).
     * Generates distinct SubmissionLog records for EVERY step approved!
     */
    public function approveSubmission(User $user, Submission $submission, ?string $notes = null, int $stepsToApprove = 1): void
    {
        if ($submission->assigned_to_user_id !== $user->id || $submission->status !== SubmissionStatus::IN_REVIEW) {
            throw new \Exception('Anda tidak memiliki wewenang untuk menyetujui pengajuan ini.');
        }

        $consecutiveStepIds = $this->detectConsecutiveStepsForUser($submission, $user);
        $maxAllowed = count($consecutiveStepIds);
        $actualToApprove = max(1, min($stepsToApprove, $maxAllowed));

        DB::transaction(function () use ($user, $submission, $consecutiveStepIds, $actualToApprove, $notes) {
            $approvedCount = 0;
            foreach ($consecutiveStepIds as $stepId) {
                if ($approvedCount >= $actualToApprove) {
                    break;
                }

                if ($submission->assigned_to_user_id !== $user->id || $submission->status !== SubmissionStatus::IN_REVIEW) {
                    break;
                }

                $currentStep = $submission->approvalFlowStep;
                $roleLabel = $currentStep?->approval_role?->label() ?? $currentStep?->name ?? 'Dosen';
                $stepNotes = !empty($notes) ? $notes : "Persetujuan diberikan sebagai {$roleLabel}.";

                $this->workflowService->approve($submission, $user, $stepNotes);
                $submission->refresh();
                $approvedCount++;
            }
        });
    }

    /**
     * Reject submission with reason and optional notes.
     */
    public function rejectSubmission(User $user, Submission $submission, string $reason, ?string $notes = null): void
    {
        if ($submission->assigned_to_user_id !== $user->id || $submission->status !== SubmissionStatus::IN_REVIEW) {
            throw new \Exception('Anda tidak memiliki wewenang untuk menolak pengajuan ini.');
        }

        $fullNotes = "Alasan: {$reason}";
        if (!empty($notes)) {
            $fullNotes .= ". Catatan: {$notes}";
        }

        $this->workflowService->reject($submission, $user, $fullNotes);
    }

    /**
     * Retrieve all distinct ApprovalRole enums that the given lecturer user holds for a specific submission.
     */
    public function getLecturerRolesForSubmission(Submission $submission, User $user): Collection
    {
        $flowSteps = $submission->letterType?->approvalFlow?->steps?->sortBy('step_order') ?? collect();
        $roles = collect();
        $assignmentService = app(SubmissionAssignmentService::class);

        foreach ($flowSteps as $step) {
            try {
                $approverUserId = $assignmentService->resolveApprover($submission, $step);
                if ($approverUserId === $user->id && $step->approval_role) {
                    $roles->push($step->approval_role);
                }
            } catch (\Throwable $e) {
                if ($submission->assigned_to_user_id === $user->id && $step->id === $submission->approval_flow_step_id && $step->approval_role) {
                    $roles->push($step->approval_role);
                }
            }
        }

        if ($roles->isEmpty()) {
            // Check logs for past actions by this user on this submission
            $loggedRoles = $submission->logs->where('user_id', $user->id)
                ->map(fn($l) => $l->approvalFlowStep?->approval_role)
                ->filter();

            if ($loggedRoles->isNotEmpty()) {
                $roles = $roles->merge($loggedRoles);
            }
        }

        if ($roles->isEmpty() && $submission->assigned_to_user_id === $user->id && $submission->approvalFlowStep?->approval_role) {
            $roles->push($submission->approvalFlowStep->approval_role);
        }

        return $roles->unique(fn($r) => $r instanceof ApprovalRole ? $r->value : (string)$r)->values();
    }
}
