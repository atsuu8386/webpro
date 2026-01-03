<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        // Ví dụ: Lấy data từ database
        $totalUsers = User::count();
        $revenue = '$' . number_format(rand(100000, 200000), 0);

        // Active users percentage (ví dụ: tính từ users active trong 24h)
        $activeUsersPercentage = rand(70, 90);

        // Visitors data cho chart (ví dụ: 30 ngày gần nhất)
        $visitorsData = $this->getVisitorsData(30);
        $visitorsLastMonthData = $this->getVisitorsData(30, 30); // 30 ngày trước đó

        // Trending data
        $trendPositive = rand(5, 10);
        $trendNegative = rand(-5, -1);
        $trendActiveUsers = rand(-3, -1);

        return view('dashboard', [
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
     *
     * @param int $days Number of days
     * @param int $offset Offset days from now
     * @return array
     */
    private function getVisitorsData($days = 30, $offset = 0)
    {
        // Ví dụ đơn giản: Generate random data
        // Trong thực tế, bạn sẽ query từ database
        $data = [];
        for ($i = 0; $i < $days; $i++) {
            $data[] = rand(7000, 11000);
        }

        // Hoặc nếu bạn có bảng analytics/visitors:
        // return DB::table('visitors')
        //     ->whereBetween('date', [
        //         now()->subDays($days + $offset)->startOfDay(),
        //         now()->subDays($offset)->endOfDay()
        //     ])
        //     ->orderBy('date')
        //     ->pluck('count')
        //     ->toArray();

        return $data;
    }
}
