<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

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
            return [
                'visitors' => 0,
                'views' => 0,
            ];
        }

        return [
            'visitors' => $today->visitors,
            'views' => $today->views,
            'unique_visitors' => $today->unique_visitors,
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
            $stats = self::currentMonth()->synced()->get();

            return [
                'total_visitors' => $stats->sum('visitors'),
                'total_views' => $stats->sum('views'),
                'avg_visitors_per_day' => round($stats->avg('visitors')),
                'avg_views_per_day' => round($stats->avg('views')),
                'days_tracked' => $stats->count(),
            ];
        });
    }

    
    public static function clearCache(): void
    {
        Cache::forget('portal_visits_monthly_chart');
        Cache::forget('portal_visits_current_month_summary');
        
        for ($days = 7; $days <= 90; $days += 7) {
            Cache::forget("portal_visits_recent_{$days}_days");
        }
    }
}