<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminDashboardService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the Admin Dashboard with stats, recent activities, and top requested letters.
     */
    public function index(AdminDashboardService $adminDashboardService): View
    {
        $stats = $adminDashboardService->getStats();
        $recentActivities = $adminDashboardService->getRecentActivities(5);
        $topRequested = $adminDashboardService->getTopRequested(3);

        return view('admin.dashboard', compact('stats', 'recentActivities', 'topRequested'));
    }
}
