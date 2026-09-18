<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class YandexMetrikaService
{
    private string $token;
    private string $counterId;
    private string $apiUrl = 'https://api-metrika.yandex.net/stat/v1/data';

    public function __construct()
    {
        $this->token = config('services.yandex_metrika.token');
        $this->counterId = config('services.yandex_metrika.counter_id');
    }


    public function getStatistics(string $startDate, string $endDate): ?array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => "OAuth {$this->token}",
            ])->get($this->apiUrl, [
                'ids' => $this->counterId,
                'metrics' => 'ym:s:visits,ym:s:pageviews,ym:s:users,ym:s:newUsers,ym:s:bounceRate,ym:s:avgVisitDurationSeconds,ym:s:pageDepth',
                'dimensions' => 'ym:s:date',
                'date1' => $startDate,
                'date2' => $endDate,
                'accuracy' => 'full',
            ]);

            if (!$response->successful()) {
                Log::error('Yandex Metrika API Error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return null;
            }

            return $this->parseResponse($response->json());
        } catch (\Exception $e) {
            Log::error('Yandex Metrika Service Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return null;
        }
    }


    public function getTodayStatistics(): ?array
    {
        $today = now()->format('Y-m-d');
        $stats = $this->getStatistics($today, $today);

        if (!$stats || empty($stats)) {
            return null;
        }

        return $stats[0] ?? null;
    }


    public function getYesterdayStatistics(): ?array
    {
        $yesterday = now()->subDay()->format('Y-m-d');
        $stats = $this->getStatistics($yesterday, $yesterday);

        if (!$stats || empty($stats)) {
            return null;
        }

        return $stats[0] ?? null;
    }

    public function getRecentStatistics(int $days = 30): ?array
    {
        $startDate = now()->subDays($days)->format('Y-m-d');
        $endDate = now()->format('Y-m-d');

        return $this->getStatistics($startDate, $endDate);
    }


    public function getCurrentMonthStatistics(): ?array
    {
        $startDate = now()->startOfMonth()->format('Y-m-d');
        $endDate = now()->format('Y-m-d');

        return $this->getStatistics($startDate, $endDate);
    }


    public function getCurrentYearMonthlyStatistics(): ?array
    {
        $startDate = now()->startOfYear()->format('Y-m-d');
        $endDate = now()->format('Y-m-d');

        $stats = $this->getStatistics($startDate, $endDate);

        if (!$stats) {
            return null;
        }


        $monthly = [];
        foreach ($stats as $stat) {
            $month = date('n', strtotime($stat['date'])); // 1-12
            
            if (!isset($monthly[$month])) {
                $monthly[$month] = [
                    'month' => $month,
                    'visitors' => 0,
                    'views' => 0,
                    'unique_visitors' => 0,
                ];
            }

            $monthly[$month]['visitors'] += $stat['visitors'];
            $monthly[$month]['views'] += $stat['views'];
            $monthly[$month]['unique_visitors'] += $stat['unique_visitors'];
        }

        return array_values($monthly);
    }


    private function parseResponse(array $response): array
    {
        if (!isset($response['data']) || empty($response['data'])) {
            return [];
        }

        $stats = [];

        foreach ($response['data'] as $item) {
            $dimensions = $item['dimensions'][0] ?? null;
            $metrics = $item['metrics'] ?? [];

            if (!$dimensions || count($metrics) < 7) {
                continue;
            }

            $date = $dimensions['name'];

            $stats[] = [
                'date' => $date,
                'visitors' => (int) $metrics[0],
                'views' => (int) $metrics[1],
                'unique_visitors' => (int) $metrics[2], 
                'new_visitors' => (int) $metrics[3], 
                'bounce_rate' => round($metrics[4], 2), 
                'avg_visit_duration' => (int) $metrics[5], 
                'page_depth' => round($metrics[6], 2), 
            ];
        }

        return $stats;
    }


    public function isConfigured(): bool
    {
        return !empty($this->token) && !empty($this->counterId);
    }


    public function test(): array
    {
        if (!$this->isConfigured()) {
            return [
                'success' => false,
                'message' => 'Яндекс.Метрика не настроена. Проверьте .env файл.',
            ];
        }

        $stats = $this->getTodayStatistics();

        if ($stats === null) {
            return [
                'success' => false,
                'message' => 'Не удалось получить данные из API. Проверьте токен и ID счётчика.',
            ];
        }

        return [
            'success' => true,
            'message' => 'Подключение успешно!',
            'data' => $stats,
        ];
    }
}