<?php

namespace App\Http\Controllers\Lecturer;

use App\Enums\SubmissionStatus;
use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Models\SubmissionLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $lecturer = $request->user()->lecturer;
        $userId = $request->user()->id;

        $pendingCount = Submission::query()
            ->where(
                'assigned_to_user_id',
                $userId
            )
            ->where(
                'status',
                SubmissionStatus::IN_REVIEW
            )
            ->count();

        $processedCount = SubmissionLog::query()
            ->where(
                'user_id',
                $userId
            )
            ->count();

        $totalCount = Submission::query()
            ->where(function ($query) use ($userId) {
                $query->where(
                    'assigned_to_user_id',
                    $userId
                )
                    ->orWhereHas(
                        'logs',
                        fn($q) =>
                        $q->where(
                            'user_id',
                            $userId
                        )
                    );
            })
            ->distinct()
            ->count();

        $percentageProcessed = $totalCount > 0 ? ($processedCount / $totalCount) * 100 : 0;

        $latestSubmissions = Submission::query()
            ->with([
                'student.user',
                'letterType',
                'approvalFlowStep',
            ])
            ->where(
                'assigned_to_user_id',
                $userId
            )
            ->latest()
            ->take(5)
            ->get();

        return view(
            'lecturer.dashboard',
            compact(
                'lecturer',
                'pendingCount',
                'processedCount',
                'totalCount',
                'percentageProcessed',
                'latestSubmissions'
            )
        );
    }
}
