<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(): View
    {
        // Ví dụ: Lấy data từ database
        $totalUsers = User::count();
        $revenue = '$' . number_format(rand(100000, 200000), 0);

        // Active users percentage
        $activeUsersPercentage = rand(70, 90);

        // Visitors data cho chart
        $visitorsData = $this->getVisitorsData(30);
        $visitorsLastMonthData = $this->getVisitorsData(30, 30);

        // Trending data
        $trendPositive = rand(5, 10);
        $trendNegative = rand(-5, -1);
        $trendActiveUsers = rand(-3, -1);

        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'revenue' => $revenue,
            'activeUsersPercentage' => $activeUsersPercentage,
            'visitorsData' => $visitorsData,
            'visitorsLastMonthData' => $visitorsLastMonthData,
            'trendPositive' => $trendPositive,
            'trendNegative' => $trendNegative,
            'trendActiveUsers' => $trendActiveUsers,
        ]);
    }

    /**
     * Get visitors data for chart
     */
    private function getVisitorsData($days = 30, $offset = 0): array
    {
        $data = [];
        for ($i = 0; $i < $days; $i++) {
            $data[] = rand(7000, 11000);
        }
        return $data;
    }
}
