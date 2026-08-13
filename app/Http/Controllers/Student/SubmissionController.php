<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StoreSubmissionRequest;
use App\Http\Requests\Student\SubmissionHistoryFilterRequest;
use App\Models\Submission;
use App\Services\ApprovalWorkflowService;
use App\Services\LetterPreviewService;
use App\Services\PdfGenerationService;
use App\Services\StudentSubmissionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubmissionController extends Controller
{
    /**
     * Display paginated submission history with server-side filters.
     */
    public function index(SubmissionHistoryFilterRequest $request, StudentSubmissionService $submissionService): View
    {
        $filters = $request->query() ?: $request->all();

        $data = $submissionService->getHistoryData($request->user(), $filters);

        return view('student.submissions.history', $data);
    }

    /**
     * Show the form for creating a new submission.
     */
    public function create(Request $request, StudentSubmissionService $submissionService): View
    {
        $data = $submissionService->getCreateFormData($request->user());

        return view('student.submissions.create', $data);
    }

    /**
     * Store a newly created submission in storage.
     */
    public function store(
        StoreSubmissionRequest $request,
        StudentSubmissionService $submissionService,
        ApprovalWorkflowService $workflowService
    ): RedirectResponse {
        $submissionService->createSubmission(
            $request->user(),
            $request->validated(),
            $request->file('attachments', []),
            $workflowService
        );

        return redirect()
            ->route('student.submissions.history')
            ->with('success', 'Pengajuan surat berhasil dikirim! Status saat ini: Sedang Diproses.');
    }

    /**
     * Display the specified submission details formatted as JSON.
     */
    public function detail(Request $request, Submission $submission): JsonResponse
    {
        $student = $request->user()->student;

        $isMember = $submission->student_id === $student?->id 
            || $submission->groupMembers()->where('student_id', $student?->id)->exists();

        abort_if(! $isMember, 403);

        $submission->load([
            'letterType',
            'currentApprovalFlowStep',
            'assignedToUser',
            'attachments',
        ]);

        return response()->json([
            'id' => $submission->id,
            'letter_type' => $submission->letterType?->name ?? 'Surat Akademik',
            'purpose' => $submission->purpose,
            'group_name' => $submission->group_name,
            'additional_data' => $submission->additional_data,
            'status' => $submission->status?->label() ?? 'Sedang Diproses',
            'submitted_at' => $submission->submitted_at?->format('d M Y H:i'),
            'current_approval_flow_step' => $submission->currentApprovalFlowStep?->name,
            'assigned_to_user' => $submission->assignedToUser?->name,
            'attachments' => $submission->attachments->map(function ($attachment) {
                return [
                    'id' => $attachment->id,
                    'name' => $attachment->original_filename,
                    'size' => $this->formatFileSize((int) $attachment->file_size),
                    'url' => route('attachments.show', $attachment->id),
                ];
            }),
        ]);
    }

    /**
     * Render the official letter document preview for a student's submission.
     */
    public function preview(
        Request $request, 
        Submission $submission, 
        LetterPreviewService $previewService
    ): View {
        $student = $request->user()?->student;

        $isMember = $submission->student_id === $student?->id 
            || $submission->groupMembers()->where('student_id', $student?->id)->exists();

        abort_if(! $isMember, 403);

        $statusStr = strtolower(is_object($submission->status) ? $submission->status->value : (string) $submission->status);
        $isFullyApproved = in_array($statusStr, ['approved', 'generated', 'disetujui']);

        abort_if(! $isFullyApproved, 403, 'Dokumen surat resmi hanya dapat diakses setelah seluruh alur pengajuan selesai disetujui.');

        return $previewService->renderSubmissionView($submission);
    }

    /**
     * Download official letter document directly as PDF file (or print preview if ?print=true).
     */
    public function download(
        Request $request, 
        Submission $submission, 
        LetterPreviewService $previewService,
        PdfGenerationService $pdfService
    ) {
        $view = $this->preview($request, $submission, $previewService);

        // If explicitly requested with ?print=true or ?view=html, return HTML print preview
        if ($request->query('print') === 'true' || $request->query('mode') === 'print' || $request->query('view') === 'html') {
            return response($view->render())
                ->header('Content-Type', 'text/html; charset=utf-8');
        }

        return $pdfService->downloadPdf($submission, $view->render());
    }

    /**
     * Helper to format attachment file size.
     */
    private function formatFileSize(int $bytes): string
    {
        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 2) . ' MB';
        }

        return round($bytes / 1024, 2) . ' KB';
    }
}
