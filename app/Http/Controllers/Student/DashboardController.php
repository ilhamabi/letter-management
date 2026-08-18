<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\StudentDashboardService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request, StudentDashboardService $dashboardService): View
    {
        $data = $dashboardService->getDashboardData($request->user());

        return view('student.dashboard', $data);
    }
}

