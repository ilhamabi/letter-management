<?php

namespace App\Http\Controllers\Lecturer;

use App\Enums\SubmissionStatus;
use App\Http\Controllers\Controller;
use App\Models\LetterType;
use App\Models\Student;
use App\Models\Submission;
use App\Services\LecturerSubmissionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubmissionController extends Controller
{
    /**
     * Display paginated list of submissions requiring lecturer's approval.
     */
    public function index(Request $request, LecturerSubmissionService $lecturerService): View
    {
        $filters = $request->query() ?: $request->all();
        $data = $lecturerService->getApprovalListData($request->user(), $filters);
        $data += $this->getFilterOptions($request, $lecturerService);

        return view('lecturer.submissions.index', $data);
    }

    /**
     * Display detailed view for a specific submission.
     */
    public function show(Request $request, Submission $submission, LecturerSubmissionService $lecturerService): View
    {
        $data = $lecturerService->getSubmissionDetailData($request->user(), $submission);

        return view('lecturer.submissions.detail', $data);
    }

    /**
     * Display paginated history of submissions processed by lecturer.
     */
    public function history(Request $request, LecturerSubmissionService $lecturerService): View
    {
        $filters = $request->query() ?: $request->all();
        $data = $lecturerService->getHistoryData($request->user(), $filters);
        $data += $this->getFilterOptions($request, $lecturerService);

        return view('lecturer.submissions.history', $data);
    }

    /**
     * Handle approval action for a submission (including batch approval for consecutive roles).
     */
    public function approve(Request $request, Submission $submission, LecturerSubmissionService $lecturerService): RedirectResponse
    {
        $notes = $request->input('notes');
        $stepsToApprove = (int) $request->input('steps_to_approve', 1);

        try {
            $lecturerService->approveSubmission($request->user(), $submission, $notes, $stepsToApprove);

            return redirect()
                ->route('lecturer.submissions.index')
                ->with('success', 'Pengajuan surat berhasil disetujui!');
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Handle rejection action for a submission.
     */
    public function reject(Request $request, Submission $submission, LecturerSubmissionService $lecturerService): RedirectResponse
    {
        $request->validate([
            'reason' => 'required|string',
            'notes' => 'nullable|string|max:1000',
        ]);

        try {
            $lecturerService->rejectSubmission(
                $request->user(),
                $submission,
                $request->input('reason'),
                $request->input('notes')
            );

            return redirect()
                ->route('lecturer.submissions.index')
                ->with('success', 'Pengajuan surat telah ditolak.');
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Helper to prepare dynamic filter dropdown options using LecturerSubmissionService.
     */
    protected function getFilterOptions(Request $request, LecturerSubmissionService $lecturerService): array
    {
        return $lecturerService->getFilterOptions($request->user());
    }
}
