<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PortalVisitStatistic;
use Illuminate\Http\JsonResponse;

class PortalVisitsController extends Controller
{

    public function getMonthlyChart(): JsonResponse
    {
        $data = PortalVisitStatistic::getMonthlyChartData();

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }


    public function getLast12MonthsChart(): JsonResponse
    {
        $data = PortalVisitStatistic::getLast12MonthsData();

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }


    public function getToday(): JsonResponse
    {
        $data = PortalVisitStatistic::getTodayStats();

        return response()->json([
            'success' => true,
            'todayVisits' => $data['visitors'] ?? 0,
            'visitors' => $data['visitors'] ?? 0,
            'views' => $data['views'] ?? 0,
            'unique_visitors' => $data['unique_visitors'] ?? 0,
            'data' => $data,
        ]);
    }


    public function getCurrentMonth(): JsonResponse
    {
        $data = PortalVisitStatistic::getCurrentMonthSummary();

        return response()->json([
            'success' => true,
            'monthVisitors' => $data['total_visitors'] ?? 0,
            'monthVisits' => $data['total_visits'] ?? 0,
            'monthViews' => $data['total_views'] ?? 0,
            'total_visitors' => $data['total_visitors'] ?? 0,
            'total_views' => $data['total_views'] ?? 0,
            'total_unique_visitors' => $data['total_unique_visitors'] ?? 0,
            'data' => $data,
        ]);
    }


    public function getRecentDays(int $days = 30): JsonResponse
    {
        $data = PortalVisitStatistic::getRecentDaysStats($days);

        return response()->json([
            'success' => true,
            'days' => $days,
            'data' => $data,
        ]);
    }


    public function getAll(): JsonResponse
    {
        $todayData = PortalVisitStatistic::getTodayStats();
        $monthData = PortalVisitStatistic::getCurrentMonthSummary();
        
        return response()->json([
            'success' => true,
            'today' => [
                'visitors' => $todayData['visitors'] ?? 0,
                'views' => $todayData['views'] ?? 0,
                'todayVisits' => $todayData['visitors'] ?? 0,
            ],
            'month' => [
                'visitors' => $monthData['total_visitors'] ?? 0,
                'views' => $monthData['total_views'] ?? 0,
                'visits' => $monthData['total_visits'] ?? 0,
                'monthVisitors' => $monthData['total_visitors'] ?? 0,
                'monthViews' => $monthData['total_views'] ?? 0,
                'monthVisits' => $monthData['total_visits'] ?? 0,
            ],
            'data' => [
                'today' => $todayData,
                'month' => $monthData,
            ]
        ]);
    }
}