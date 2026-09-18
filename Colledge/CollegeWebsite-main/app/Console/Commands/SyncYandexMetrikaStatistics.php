<?php

namespace App\Console\Commands;

use App\Models\DashboardStatistic;
use App\Models\PortalVisitStatistic;
use App\Services\YandexMetrikaService;
use Illuminate\Console\Command;

class SyncYandexMetrikaStatistics extends Command
{
    protected $signature = 'metrika:sync {--days=7 : Количество дней для синхронизации}';
    protected $description = 'Синхронизация статистики из Яндекс.Метрики';

    private YandexMetrikaService $metrika;

    public function __construct(YandexMetrikaService $metrika)
    {
        parent::__construct();
        $this->metrika = $metrika;
    }

    public function handle(): int
    {
        $this->info('🚀 Начинаю синхронизацию с Яндекс.Метрикой...');

        if (!$this->metrika->isConfigured()) {
            $this->error('❌ Яндекс.Метрика не настроена. Проверьте .env файл.');
            return Command::FAILURE;
        }

        $days = (int) $this->option('days');
        $this->info("📅 Синхронизирую данные за последние {$days} дней...");

        $stats = $this->metrika->getRecentStatistics($days);

        if (!$stats) {
            $this->error('❌ Не удалось получить данные из API.');
            return Command::FAILURE;
        }

        $this->info('✅ Получено записей: ' . count($stats));

        $progressBar = $this->output->createProgressBar(count($stats));
        $progressBar->start();

        $synced = 0;
        $errors = 0;

        foreach ($stats as $stat) {
            try {
                PortalVisitStatistic::updateOrCreate(
                    ['date' => $stat['date']],
                    [
                        'visitors' => $stat['visitors'],
                        'views' => $stat['views'],
                        'unique_visitors' => $stat['unique_visitors'],
                        'new_visitors' => $stat['new_visitors'],
                        'bounce_rate' => $stat['bounce_rate'],
                        'avg_visit_duration' => $stat['avg_visit_duration'],
                        'page_depth' => $stat['page_depth'],
                        'synced_at' => now(),
                        'sync_status' => 'synced',
                        'sync_error' => null,
                    ]
                );

                $synced++;
            } catch (\Exception $e) {
                $errors++;
                $this->error("\n❌ Ошибка для {$stat['date']}: {$e->getMessage()}");

                PortalVisitStatistic::updateOrCreate(
                    ['date' => $stat['date']],
                    [
                        'sync_status' => 'error',
                        'sync_error' => $e->getMessage(),
                    ]
                );
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);

        $this->updateDashboardStatistics();

        PortalVisitStatistic::clearCache();

        $this->info("✅ Синхронизировано: {$synced}");
        if ($errors > 0) {
            $this->warn("⚠️  Ошибок: {$errors}");
        }

        $this->info('🎉 Синхронизация завершена!');

        return Command::SUCCESS;
    }


    private function updateDashboardStatistics(): void
    {
        $this->info('📊 Обновляю статистику дашборда...');

        $today = PortalVisitStatistic::getTodayStats();

        $portalVisitsStat = DashboardStatistic::where('key', 'admin_portal_visits')->first();
        if ($portalVisitsStat) {
            $portalVisitsStat->updateValue((string) $today['visitors']);
            $this->info("  ✓ Посещения за сегодня: {$today['visitors']}");
        }

        $monthSummary = PortalVisitStatistic::getCurrentMonthSummary();
        $this->info("  ✓ За месяц: {$monthSummary['total_visitors']} посетителей, {$monthSummary['total_views']} просмотров");
    }
}