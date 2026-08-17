<?php

namespace App\Services;

use App\Enums\ApprovalRole;
use App\Enums\SubmissionLogStatus;
use App\Enums\SubmissionStatus;
use App\Models\LecturerPosition;
use App\Models\LetterType;
use App\Models\Student;
use App\Models\StudentLecturer;
use App\Models\Submission;
use App\Models\SubmissionAttachment;
use App\Services\SubmissionAssignmentService;
use App\Models\SubmissionGroupMember;
use App\Models\SubmissionLog;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StudentSubmissionService
{
    /**
     * Retrieve paginated submission history for a student with applied filters.
     */
    public function getHistoryData(User $user, array $filters): array
    {
        $student = $user->student;

        $letterTypes = LetterType::query()
            ->where('is_active', true)
            ->orderBy('name', 'asc')
            ->get();

        $query = Submission::query();

        if ($student) {
            $query->where(function ($q) use ($student) {
                $q->where('student_id', $student->id)
                  ->orWhereHas('groupMembers', function ($g) use ($student) {
                      $g->where('student_id', $student->id);
                  });
            });
        }

        // Apply date range filters
        $startDate = $filters['start_date'] ?? null;
        $endDate = $filters['end_date'] ?? null;

        if ($startDate && $endDate) {
            if ($startDate > $endDate) {
                [$startDate, $endDate] = [$endDate, $startDate];
            }
            $query->whereDate('submitted_at', '>=', $startDate)
                  ->whereDate('submitted_at', '<=', $endDate);
        } elseif ($startDate) {
            $query->whereDate('submitted_at', '>=', $startDate);
        } elseif ($endDate) {
            $query->whereDate('submitted_at', '<=', $endDate);
        }

        // Apply letter type filter
        if (!empty($filters['letter_type_id'])) {
            $query->where('letter_type_id', $filters['letter_type_id']);
        }

        // Apply submission status filter
        if (!empty($filters['status'])) {
            $statusInput = strtolower((string) $filters['status']);

            if (in_array($statusInput, ['diproses', 'in_review'])) {
                $query->whereIn('status', [
                    SubmissionStatus::PENDING->value,
                    SubmissionStatus::IN_REVIEW->value,
                ]);
            } elseif (in_array($statusInput, ['disetujui', 'approved'])) {
                $query->whereIn('status', [
                    SubmissionStatus::APPROVED->value,
                    SubmissionStatus::GENERATED->value,
                ]);
            } elseif (in_array($statusInput, ['ditolak', 'rejected'])) {
                $query->where('status', SubmissionStatus::REJECTED->value);
            } else {
                $query->where('status', $filters['status']);
            }
        }

        $submissions = $query
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
            ->latest('submitted_at')
            ->paginate(10)
            ->withQueryString();

        return compact('submissions', 'letterTypes');
    }

    /**
     * Retrieve prerequisite form data for creating a new submission.
     */
    public function getCreateFormData(User $user): array
    {
        $student = $user->student;

        $letterTypes = LetterType::query()
            ->where('is_active', true)
            ->with('approvalFlow.steps')
            ->orderBy('name', 'asc')
            ->get();

        $academicAdvisor = StudentLecturer::query()
            ->where('student_id', $student?->id)
            ->where('lecturer_role', ApprovalRole::ACADEMIC_ADVISOR->value)
            ->where('is_active', true)
            ->with('lecturer.user')
            ->first()?->lecturer;

        $kaprodi = LecturerPosition::query()
            ->where('position', ApprovalRole::HEAD_OF_STUDY_PROGRAM->value)
            ->where('is_active', true)
            ->with('lecturer.user')
            ->first()?->lecturer;

        $letterTypesWithApprovers = [];
        foreach ($letterTypes as $type) {
            $approvers = [];
            if ($type->approvalFlow && $type->approvalFlow->steps) {
                $steps = $type->approvalFlow->steps->sortBy('step_order');
                foreach ($steps as $step) {
                    try {
                        $tempSubmission = new Submission([
                            'student_id' => $student?->id,
                            'letter_type_id' => $type->id,
                        ]);
                        if ($student) {
                            $tempSubmission->setRelation('student', $student);
                        }
                        $approverId = app(SubmissionAssignmentService::class)->resolveApprover($tempSubmission, $step);
                        $approverUser = User::find($approverId);
                        $approverName = $approverUser?->name ?? 'Belum Ditentukan';
                        $lecturer = $approverUser?->lecturer;
                        $nik = $lecturer?->employee_number ?? '—';
                        $email = $approverUser?->email ?? '—';
                    } catch (\Exception $e) {
                        $approverName = 'Belum Ditentukan';
                        $nik = '—';
                        $email = '—';
                    }
                    $approvers[] = [
                        'role' => $step->approval_role?->label() ?? $step->name,
                        'name' => $approverName,
                        'nik' => $nik,
                        'email' => $email,
                    ];
                }
            }
            $letterTypesWithApprovers[$type->id] = $approvers;
        }

        return compact('student', 'letterTypes', 'letterTypesWithApprovers', 'academicAdvisor', 'kaprodi');
    }

    /**
     * Create a submission with attachments, group members, and initial log entry.
     */
    public function createSubmission(User $user, array $data, array $attachments, ApprovalWorkflowService $workflowService): Submission
    {
        return DB::transaction(function () use ($user, $data, $attachments, $workflowService) {
            $student = $user->student;

            $additionalData = $data['additional_data'] ?? [];

            // Extract any known institution or academic extra fields into additional_data array
            foreach (['company_name', 'company_address', 'start_date', 'end_date', 'thesis_title', 'total_credits', 'gpa'] as $field) {
                if (!empty($data[$field]) && !isset($additionalData[$field])) {
                    $additionalData[$field] = $data[$field];
                }
            }

            $letterType = LetterType::find($data['letter_type_id']);

            $submission = Submission::create([
                'student_id' => $student->id,
                'letter_type_id' => $data['letter_type_id'],
                'approval_flow_id' => $letterType?->approval_flow_id,
                'purpose' => $data['purpose'],
                'group_name' => $data['group_name'] ?? null,
                'additional_data' => count($additionalData) > 0 ? $additionalData : null,
                'status' => SubmissionStatus::IN_REVIEW,
                'submitted_at' => now(),
            ]);

            // Store uploaded attachments
            foreach ($attachments as $attachment) {
                $storedName = Str::uuid() . '.' . $attachment->getClientOriginalExtension();
                $path = $attachment->storeAs('submissions', $storedName, 'public');

                SubmissionAttachment::create([
                    'submission_id' => $submission->id,
                    'original_filename' => $attachment->getClientOriginalName(),
                    'stored_filename' => $storedName,
                    'file_path' => $path,
                    'file_size' => $attachment->getSize(),
                    'mime_type' => $attachment->getClientMimeType(),
                ]);
            }

            // Save group members if submission type supports team requests
            $isGroupSubmission = false;
            if (!empty($data['group_members']) && is_array($data['group_members'])) {
                $sortOrder = 1;
                foreach ($data['group_members'] as $memberNim) {
                    $memberNim = trim((string) $memberNim);
                    if (empty($memberNim)) {
                        continue;
                    }

                    $memberStudent = Student::where('student_number', $memberNim)->first();
                    if ($memberStudent && $memberStudent->id !== $student->id) {
                        SubmissionGroupMember::create([
                            'submission_id' => $submission->id,
                            'student_id' => $memberStudent->id,
                            'sort_order' => $sortOrder++,
                        ]);
                        $isGroupSubmission = true;
                    }
                }
            }

            // Record initial submission log
            SubmissionLog::create([
                'submission_id' => $submission->id,
                'approval_flow_step_id' => null,
                'user_id' => $user->id,
                'status' => SubmissionLogStatus::APPROVED,
                'notes' => $isGroupSubmission
                    ? 'Pengajuan kelompok berhasil dibuat dan dikirim oleh mahasiswa.'
                    : 'Pengajuan surat berhasil dibuat dan dikirim oleh mahasiswa.',
            ]);

            // Assign first approver in workflow
            $workflowService->assignFirstApprover($submission->fresh([
                'letterType.approvalFlow.steps',
            ]));

            return $submission;
        });
    }
}
