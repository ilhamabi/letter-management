<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Services\LecturerSubmissionService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the lecturer dashboard with metrics and recent pending requests.
     */
    public function index(Request $request, LecturerSubmissionService $lecturerService): View
    {
        $data = $lecturerService->getDashboardData($request->user());

        return view('lecturer.dashboard', $data);
    }
}
