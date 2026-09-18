<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PortalVisitStatistic extends Model
{
    protected $fillable = [
        'date',
        'visitors',
        'views',
        'unique_visitors',
        'new_visitors',
        'bounce_rate',
        'avg_visit_duration',
        'page_depth',
        'synced_at',
        'sync_status',
        'sync_error',
    ];

    protected $casts = [
        'date' => 'date',
        'synced_at' => 'datetime',
        'bounce_rate' => 'decimal:2',
        'page_depth' => 'decimal:2',
    ];


    public function scopeSynced($query)
    {
        return $query->where('sync_status', 'synced');
    }

    public function scopeForPeriod($query, $startDate, $endDate)
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }

    public function scopeCurrentYear($query)
    {
        return $query->whereYear('date', now()->year);
    }

    public function scopeCurrentMonth($query)
    {
        return $query->whereYear('date', now()->year)
                    ->whereMonth('date', now()->month);
    }


    public static function getTodayStats(): array
    {
        $today = self::whereDate('date', today())
                    ->synced()
                    ->first();

        if (!$today) {
  
            $lastStat = self::synced()->orderBy('date', 'desc')->first();
            
            if ($lastStat) {
                return [
                    'visitors' => $lastStat->visitors,
                    'views' => $lastStat->views,
                    'unique_visitors' => $lastStat->unique_visitors,
                    'new_visitors' => $lastStat->new_visitors ?? 0,
                    'bounce_rate' => $lastStat->bounce_rate ?? 35.5,
                    'avg_visit_duration' => $lastStat->avg_visit_duration ?? 120,
                    'page_depth' => $lastStat->page_depth ?? 2.1,
                ];
            }
            
            return [
                'visitors' => 0,
                'views' => 0,
                'unique_visitors' => 0,
                'new_visitors' => 0,
                'bounce_rate' => 0,
                'avg_visit_duration' => 0,
                'page_depth' => 0,
            ];
        }

        return [
            'visitors' => $today->visitors,
            'views' => $today->views,
            'unique_visitors' => $today->unique_visitors,
            'new_visitors' => $today->new_visitors ?? 0,
            'bounce_rate' => $today->bounce_rate ?? 0,
            'avg_visit_duration' => $today->avg_visit_duration ?? 0,
            'page_depth' => $today->page_depth ?? 0,
        ];
    }


    public static function getMonthlyChartData(): array
    {
        return Cache::remember('portal_visits_monthly_chart', 600, function () {
            $stats = self::currentYear()
                ->synced()
                ->select(
                    DB::raw('MONTH(date) as month'),
                    DB::raw('SUM(visitors) as total_visitors'),
                    DB::raw('SUM(views) as total_views')
                )
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            $months = [
                'Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн',
                'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'
            ];

            $visitors = array_fill(0, 12, 0);
            $views = array_fill(0, 12, 0);

            foreach ($stats as $stat) {
                $monthIndex = $stat->month - 1;
                $visitors[$monthIndex] = (int) $stat->total_visitors;
                $views[$monthIndex] = (int) $stat->total_views;
            }

            return [
                'labels' => $months,
                'visitors' => $visitors,
                'views' => $views,
            ];
        });
    }


    public static function getRecentDaysStats(int $days = 30): array
    {
        return Cache::remember("portal_visits_recent_{$days}_days", 600, function () use ($days) {
            return self::whereBetween('date', [now()->subDays($days), now()])
                ->synced()
                ->orderBy('date')
                ->get()
                ->map(function ($stat) {
                    return [
                        'date' => $stat->date->format('d.m'),
                        'visitors' => $stat->visitors,
                        'views' => $stat->views,
                    ];
                })
                ->toArray();
        });
    }


    public static function getCurrentMonthSummary(): array
    {
        return Cache::remember('portal_visits_current_month_summary', 600, function () {
            $now = Carbon::now();
            $startOfMonth = $now->copy()->startOfMonth();
            $endOfMonth = $now->copy()->endOfMonth();
            
            $stats = self::whereBetween('date', [$startOfMonth, $endOfMonth])
                ->synced()
                ->get();

            if ($stats->isEmpty()) {
                // Если данных нет, возвращаем дефолтные значения
                return [
                    'total_visitors' => 0,
                    'total_views' => 0,
                    'total_unique_visitors' => 0,
                    'total_visits' => 0,
                    'total_new_visitors' => 0,
                    'avg_visitors_per_day' => 0,
                    'avg_views_per_day' => 0,
                    'avg_bounce_rate' => 0,
                    'avg_visit_duration' => 0,
                    'avg_page_depth' => 0,
                    'days_tracked' => 0,
                    'month' => $now->format('F Y'),
                ];
            }

            return [
                'total_visitors' => (int) $stats->sum('visitors'),
                'total_views' => (int) $stats->sum('views'),
                'total_unique_visitors' => (int) $stats->sum('unique_visitors'),
                'total_visits' => (int) $stats->sum('visitors'),
                'total_new_visitors' => (int) $stats->sum('new_visitors'),
                'avg_visitors_per_day' => (int) round($stats->avg('visitors')),
                'avg_views_per_day' => (int) round($stats->avg('views')),
                'avg_bounce_rate' => (float) round($stats->avg('bounce_rate'), 2),
                'avg_visit_duration' => (int) round($stats->avg('avg_visit_duration')),
                'avg_page_depth' => (float) round($stats->avg('page_depth'), 2),
                'days_tracked' => $stats->count(),
                'month' => $now->format('F Y'),
            ];
        });
    }


    public static function getLast12MonthsData(): array
    {
        return Cache::remember('portal_visits_last_12_months', 3600, function () {
            $now = Carbon::now();
            $startDate = $now->copy()->subMonths(11)->startOfMonth();
            $endDate = $now->copy()->endOfMonth();
            
            $stats = self::whereBetween('date', [$startDate, $endDate])
                ->synced()
                ->select(
                    DB::raw('YEAR(date) as year'),
                    DB::raw('MONTH(date) as month'),
                    DB::raw('SUM(visitors) as total_visitors'),
                    DB::raw('SUM(views) as total_views')
                )
                ->groupBy('year', 'month')
                ->orderBy('year')
                ->orderBy('month')
                ->get()
                ->keyBy(function ($item) {
                    return $item->year . '-' . str_pad($item->month, 2, '0', STR_PAD_LEFT);
                });

            $months = [];
            $visitors = [];
            $views = [];
            
            $current = $startDate->copy();
            
            while ($current <= $endDate) {
                $key = $current->format('Y-m');
                $monthLabel = $current->format('M Y');
                
                $months[] = $monthLabel;
                $visitors[] = isset($stats[$key]) ? (int) $stats[$key]->total_visitors : 0;
                $views[] = isset($stats[$key]) ? (int) $stats[$key]->total_views : 0;
                
                $current->addMonth();
            }

            return [
                'labels' => $months,
                'visitors' => $visitors,
                'views' => $views,
            ];
        });
    }


    public static function clearCache(): void
    {
        Cache::forget('portal_visits_monthly_chart');
        Cache::forget('portal_visits_current_month_summary');
        Cache::forget('portal_visits_last_12_months');
        
        for ($days = 7; $days <= 90; $days += 7) {
            Cache::forget("portal_visits_recent_{$days}_days");
        }
    }
}