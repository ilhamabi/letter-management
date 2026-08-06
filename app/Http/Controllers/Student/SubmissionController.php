<?php

namespace App\Http\Controllers\Student;

use App\Enums\SubmissionStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubmissionRequest;
use App\Models\LetterType;
use App\Models\Submission;
use App\Models\SubmissionAttachment;
use App\Services\ApprovalWorkflowService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SubmissionController extends Controller
{
    public function index(Request $request)
    {
        $student = $request->user()->student;

        $submissions = Submission::query()
            ->where('student_id', $student->id)
            ->with([
                'letterType',
                'approvalFlowStep',
                'assignedToUser',
            ])
            ->latest('created_at')
            ->paginate(10);

        return view('student.submissions.history', compact('submissions'));
    }

    public function create(Request $request)
    {
        $student = $request->user()->student;

        $letterTypes = LetterType::query()
            ->where('is_active', true)
            ->orderBy('name', 'asc')
            ->get();

        return view(
            'student.submissions.create',
            compact('student', 'letterTypes')
        );
    }

    public function store(StoreSubmissionRequest $request, ApprovalWorkflowService $workflowService)
    {
        DB::transaction(function () use ($request, $workflowService) {
            $student = $request->user()->student;

            $submission = Submission::create([
                'student_id' => $student->id,
                'letter_type_id' => $request->letter_type_id,
                'purpose' => $request->purpose,
                'status' => SubmissionStatus::IN_REVIEW,
            ]);

            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $attachment) {
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
            }

            $workflowService->assignFirstApprover($submission->fresh([
                'letterType.approvalFlow.steps',
            ]));
        });

        return redirect()
            ->route('student.submissions.history')
            ->with('success', 'Submission created successfully.');
    }

    public function detail(Request $request, Submission $submission)
    {
        $student = $request->user()->student;

        abort_if($submission->student_id !== $student->id, 403);

        $submission->load([
            'letterType',
            'currentApprovalFlowStep',
            'assignedToUser',
            'attachments',
        ]);

        return response()->json([
            'id' => $submission->id,
            'letter_type' => $submission->letterType->name,
            'purpose' => $submission->purpose,
            'status' => $submission->status->label(),
            'submitted_at' => $submission->submitted_at?->format('d M Y H:i'),
            'current_approval_flow_step' => $submission->currentApprovalFlowStep?->name,
            'assigned_to_user' => $submission->assignedToUser?->name,
            'attachments' => $submission->attachments->map(function ($attachment) {
                return [
                    'name' => $attachment->original_filename,
                    'size' => $this->formatFileSize($attachment->file_size),
                    'url' => asset('storage/' . $attachment->file_path),
                ];
            }),
        ]);
    }

    private function formatFileSize(int $bytes): string
    {
        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 2) . ' MB';
        }

        return round($bytes / 1024, 2) . ' KB';
    }
}
