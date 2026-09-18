<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DashboardStatistic;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{

    public function index(): JsonResponse
    {
        try {
            $statistics = DashboardStatistic::getAllCached();
            
            return response()->json([
                'success' => true,
                'data' => $statistics,
                'timestamp' => now()->format('Y-m-d H:i:s'),
                'total' => count($statistics),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch dashboard data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function category(string $category): JsonResponse
    {
        try {
            $validCategories = ['academic', 'events', 'services', 'tech'];
            
            if (!in_array($category, $validCategories)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid category',
                    'valid_categories' => $validCategories,
                ], 400);
            }

            $statistics = DashboardStatistic::getCachedByCategory($category);
            
            return response()->json([
                'success' => true,
                'category' => $category,
                'statistics' => $statistics,
                'count' => count($statistics),
                'timestamp' => now()->format('Y-m-d H:i:s'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch category data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function getByKey(string $key): JsonResponse
    {
        try {
            $statistic = DashboardStatistic::where('key', $key)
                ->active()
                ->first();

            if (!$statistic) {
                return response()->json([
                    'success' => false,
                    'message' => 'Statistic not found',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'statistic' => $statistic->toApiResponse(),
                'timestamp' => now()->format('Y-m-d H:i:s'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch statistic',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function refresh(string $key, Request $request): JsonResponse
    {
        try {
            $statistic = DashboardStatistic::where('key', $key)->first();

            if (!$statistic) {
                return response()->json([
                    'success' => false,
                    'message' => 'Statistic not found',
                ], 404);
            }

            $newValue = $request->input('value');
            
            if (!$newValue) {
                return response()->json([
                    'success' => false,
                    'message' => 'Value is required',
                ], 400);
            }

            $statistic->updateValue($newValue);

            return response()->json([
                'success' => true,
                'message' => 'Statistic updated successfully',
                'statistic' => $statistic->toApiResponse(),
                'timestamp' => now()->format('Y-m-d H:i:s'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update statistic',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function summary(): JsonResponse
    {
        try {
            $categories = ['academic', 'events', 'services', 'tech'];
            $summary = [];
            $totalActive = 0;
            $totalStatistics = 0;

            foreach ($categories as $category) {
                $stats = DashboardStatistic::getCachedByCategory($category);
                $summary[$category] = [
                    'count' => count($stats),
                    'label' => DashboardStatistic::getCategories()[$category] ?? $category,
                ];
                $totalStatistics += count($stats);
            }

            $totalActive = DashboardStatistic::active()->count();

            return response()->json([
                'success' => true,
                'summary' => $summary,
                'total_active' => $totalActive,
                'total_statistics' => $totalStatistics,
                'categories' => DashboardStatistic::getCategories(),
                'timestamp' => now()->format('Y-m-d H:i:s'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch summary',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function tabData(string $tab): JsonResponse
    {
        try {
            $tabMapping = [
                'academic' => 'academic',
                'events' => 'events',
                'services' => 'services',
                'tech' => 'tech',
            ];

            if (!isset($tabMapping[$tab])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid tab',
                    'valid_tabs' => array_keys($tabMapping),
                ], 400);
            }

            $category = $tabMapping[$tab];
            $statistics = DashboardStatistic::getCachedByCategory($category);
            

            $formattedStats = [];
            foreach ($statistics as $stat) {
                $formattedStats[$stat['key']] = [
                    'value' => $stat['value'],
                    'formatted_value' => $stat['formatted_value'],
                    'growth' => $stat['growth_percentage'],
                    'unit' => $stat['unit'],
                ];
            }

            return response()->json([
                'success' => true,
                'tab' => $tab,
                'category' => $category,
                'statistics' => $formattedStats,
                'count' => count($statistics),
                'timestamp' => now()->format('Y-m-d H:i:s'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch tab data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function getAllData(): JsonResponse
    {
        return $this->index();
    }

    public function getByCategory(string $category): JsonResponse
    {
        return $this->category($category);
    }
}