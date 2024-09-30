<?php

namespace App\Http\Controllers;

use App\Models\Application;

class DashboardController extends Controller
{
    public function HomePage()
    {
        $applications = Application::all();

        $totalApplications = $applications->count();
        $completedApplications = $applications->where('status', 'full-done')->count();
        $incompleteApplications = $totalApplications - $completedApplications;

        $completionPercentage = ($totalApplications > 0) ? ($completedApplications / $totalApplications) * 100 : 0;
        $incompletePercentage = ($totalApplications > 0) ? ($incompleteApplications / $totalApplications) * 100 : 0;

        $result = [
            'total_applications' => $totalApplications,
            'completed_applications' => $completedApplications,
            'incomplete_applications' => $incompleteApplications,
            'completion_percentage' => round($completionPercentage, 2),
            'incomplete_percentage' => round($incompletePercentage, 2),
        ];

        return view('Pages.dashboard.index', compact('result'));
    }
}
