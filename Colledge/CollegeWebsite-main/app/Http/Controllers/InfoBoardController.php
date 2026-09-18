<?php

namespace App\Http\Controllers;

use App\Models\Statistic;
use App\Models\PortalVisit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class InfoBoardController extends Controller
{
    public function index()
    {
        return view('infoboard.index');
    }

    public function getData()
    {
        return Cache::remember('dashboard_data_all', 30, function () {
            $statistics = Statistic::active()
                ->ordered()
                ->get()
                ->groupBy('category')
                ->map(function ($items) {
                    return $items->map(function ($stat) {
                        return [
                            'key' => $stat->key,
                            'label' => $stat->label,
                            'value' => $stat->value,
                            'color' => $stat->color,
                            'growth' => $stat->getGrowthPercentage(),
                            'formatted_value' => $stat->formatted_value,
                        ];
                    })->values();
                });

            return response()->json([
                'success' => true,
                'statistics' => $statistics,
                'last_update' => now()->toIso8601String(),
            ]);
        });
    }

    public function getCategory($category)
    {
        $validCategories = ['academic', 'events', 'services', 'tech'];
        
        if (!in_array($category, $validCategories)) {
            return response()->json([
                'success' => false,
                'message' => 'Неверная категория',
            ], 400);
        }

        return Cache::remember("dashboard_data_{$category}", 30, function () use ($category) {
            $statistics = Statistic::active()
                ->byCategory($category)
                ->ordered()
                ->get()
                ->map(function ($stat) {
                    return [
                        'key' => $stat->key,
                        'label' => $stat->label,
                        'value' => $stat->value,
                        'color' => $stat->color,
                        'growth' => $stat->getGrowthPercentage(),
                        'formatted_value' => $stat->formatted_value,
                    ];
                });

            return response()->json([
                'success' => true,
                'category' => $category,
                'statistics' => $statistics,
                'last_update' => now()->toIso8601String(),
            ]);
        });
    }

    public function getStatisticHistory(Request $request, string $key)
    {
        $days = $request->get('days', 30);
        
        $statistic = Statistic::where('key', $key)->first();
        
        if (!$statistic) {
            return response()->json([
                'success' => false,
                'message' => 'Показатель не найден',
            ], 404);
        }
        
        return Cache::remember("statistic_history_{$key}_{$days}", 300, function () use ($statistic, $days) {
            $chartData = $statistic->getChartData($days);
            $trend = $statistic->getTrend(7);
            $avgGrowth = $statistic->getAverageGrowth($days);
            
            return response()->json([
                'success' => true,
                'statistic' => [
                    'key' => $statistic->key,
                    'label' => $statistic->label,
                    'current_value' => $statistic->value,
                ],
                'chart' => $chartData,
                'analysis' => [
                    'trend' => $trend,
                    'average_growth' => $avgGrowth,
                ],
            ]);
        });
    }

    public function getPortalActivity($period = 'week')
    {
        return Cache::remember("portal_activity_{$period}", 60, function () use ($period) {
            $data = match($period) {
                'day' => $this->getDayActivity(),
                'week' => $this->getWeekActivity(),
                'month' => $this->getMonthActivity(),
                default => $this->getWeekActivity(),
            };

            return response()->json([
                'success' => true,
                'period' => $period,
                'data' => $data,
                'total' => array_sum(array_column($data, 'visits')),
            ]);
        });
    }

    protected function getDayActivity(): array
    {
        $data = [];
        $today = Carbon::today();

        for ($hour = 0; $hour < 24; $hour++) {
            $startHour = $today->copy()->addHours($hour);
            $endHour = $startHour->copy()->addHour();

            $visits = PortalVisit::whereBetween('visited_at', [$startHour, $endHour])
                ->count();

            $data[] = [
                'label' => $startHour->format('H:00'),
                'visits' => $visits,
            ];
        }

        return $data;
    }

    protected function getWeekActivity(): array
    {
        $data = [];
        $daysOfWeek = ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'];

        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::today()->subDays($i);
            
            $visits = PortalVisit::whereDate('visited_at', $day)->count();

            $data[] = [
                'label' => $daysOfWeek[$day->dayOfWeekIso - 1],
                'date' => $day->format('d.m'),
                'visits' => $visits,
            ];
        }

        return $data;
    }

    protected function getMonthActivity(): array
    {
        $data = [];
        $weeksCount = 4;

        for ($i = $weeksCount - 1; $i >= 0; $i--) {
            $endDate = Carbon::today()->subWeeks($i);
            $startDate = $endDate->copy()->subWeek();

            $visits = PortalVisit::whereBetween('visited_at', [$startDate, $endDate])
                ->count();

            $data[] = [
                'label' => "Неделя " . ($weeksCount - $i),
                'period' => $startDate->format('d.m') . ' - ' . $endDate->format('d.m'),
                'visits' => $visits,
            ];
        }

        return $data;
    }

    public function forceUpdate()
    {
        try {
            $statistics = Statistic::automatic()->get();
            
            foreach ($statistics as $statistic) {
                $statistic->updateValue();
            }

            Cache::forget('dashboard_data_all');
            foreach (['academic', 'events', 'services', 'tech'] as $category) {
                Cache::forget("dashboard_data_{$category}");
            }
            foreach (['day', 'week', 'month'] as $period) {
                Cache::forget("portal_activity_{$period}");
            }

            return response()->json([
                'success' => true,
                'message' => 'Статистика обновлена',
                'updated_count' => $statistics->count(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}