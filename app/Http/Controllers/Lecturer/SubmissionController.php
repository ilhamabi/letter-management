<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function index(Request $request)
    {
        $lecturer = $request->user()->lecturer;
        $userId = $request->user()->id;

        $submissions = Submission::query()
            ->where('assigned_to_user_id', $userId)
            ->with([
                'student.user',
                'letterType',
                'approvalFlowStep',
            ])
            ->where(
                'status',
                'IN_REVIEW'
            )
            ->latest('created_at')
            ->paginate(10);

        return view(
            'lecturer.submissions.index',
            compact('submissions')
        );
    }
}
