<?php

namespace App\Console\Commands;

use App\Models\BlogPost;
use App\Models\DashboardStatistic;
use App\Models\PortalVisit;
use App\Models\Question;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UpdateDashboardStatistics extends Command
{
    protected $signature = 'dashboard:update-statistics';
    protected $description = 'Обновить автоматические статистики дашборда';

    public function handle(): int
    {
        $this->info('🔄 Начинаю обновление статистик дашборда...');

        $this->updatePortalVisits();

        $this->updateBlogAppeals();

        $this->updateInstagram();
        $this->updateTelegram();
        $this->updateYoutube();

        $this->info('✅ Статистики успешно обновлены!');

        return Command::SUCCESS;
    }


    private function updatePortalVisits(): void
    {
        $this->info('📊 Обновляю посещения портала...');

        try {

            \Artisan::call('metrika:sync', ['--days' => 1]);
            

            $todayStats = \App\Models\PortalVisitStatistic::getTodayStats();
            $todayVisits = $todayStats['visitors'];

            $stat = DashboardStatistic::where('update_source', DashboardStatistic::SOURCE_PORTAL_VISITS)
                ->where('is_auto_updated', true)
                ->first();

            if ($stat) {
                $stat->updateValue((string) $todayVisits);
                $this->info("  ✓ Посещения портала: {$todayVisits}");
            }
        } catch (\Exception $e) {
            $this->error("  ✗ Ошибка обновления посещений: {$e->getMessage()}");
            Log::error('Dashboard Update Portal Visits Error', ['error' => $e->getMessage()]);
        }
    }


    private function updateBlogAppeals(): void
    {
        $this->info('💬 Обновляю обращения в блог...');

        try {

            $appealsCount = Question::whereNotNull('answer')
                ->whereMonth('created_at', now()->month)
                ->count();

            $stat = DashboardStatistic::where('update_source', DashboardStatistic::SOURCE_BLOG_APPEALS)
                ->where('is_auto_updated', true)
                ->first();

            if ($stat) {
                $stat->updateValue((string) $appealsCount);
                $this->info("  ✓ Обращения в блог: {$appealsCount}");
            }
        } catch (\Exception $e) {
            $this->error("  ✗ Ошибка обновления обращений: {$e->getMessage()}");
            Log::error('Dashboard Update Blog Appeals Error', ['error' => $e->getMessage()]);
        }
    }


    private function updateInstagram(): void
    {
        $this->info('📸 Обновляю Instagram...');

        try {

            
            $this->warn('  ⚠ Instagram API не настроен. Используйте ручное обновление.');
        } catch (\Exception $e) {
            $this->error("  ✗ Ошибка обновления Instagram: {$e->getMessage()}");
            Log::error('Dashboard Update Instagram Error', ['error' => $e->getMessage()]);
        }
    }


    private function updateTelegram(): void
    {
        $this->info('✈️ Обновляю Telegram...');

        try {
            $botToken = config('services.telegram.bot_token');
            $channelUsername = config('services.telegram.channel_username', '@vkeik_kz');

            if (!$botToken) {
                $this->warn('  ⚠ Telegram Bot Token не настроен в .env');
                return;
            }


            $response = Http::get("https://api.telegram.org/bot{$botToken}/getChat", [
                'chat_id' => $channelUsername,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['result']['members_count'])) {
                    $followers = $data['result']['members_count'];

                    $stat = DashboardStatistic::where('update_source', DashboardStatistic::SOURCE_TELEGRAM)
                        ->where('is_auto_updated', true)
                        ->first();

                    if ($stat) {
                        $stat->updateValue((string) number_format($followers, 0, '', ' '));
                        $this->info("  ✓ Telegram подписчики: {$followers}");
                    }
                } else {
                    $this->warn('  ⚠ Не удалось получить количество подписчиков Telegram');
                }
            }
        } catch (\Exception $e) {
            $this->error("  ✗ Ошибка обновления Telegram: {$e->getMessage()}");
            Log::error('Dashboard Update Telegram Error', ['error' => $e->getMessage()]);
        }
    }


    private function updateYoutube(): void
    {
        $this->info('▶️ Обновляю YouTube...');

        try {
            $apiKey = config('services.youtube.api_key');
            $channelId = config('services.youtube.channel_id');

            if (!$apiKey || !$channelId) {
                $this->warn('  ⚠ YouTube API не настроен в .env');
                return;
            }


            $response = Http::get('https://www.googleapis.com/youtube/v3/channels', [
                'part' => 'statistics',
                'id' => $channelId,
                'key' => $apiKey,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['items'][0]['statistics']['subscriberCount'])) {
                    $subscribers = $data['items'][0]['statistics']['subscriberCount'];

                    $stat = DashboardStatistic::where('update_source', DashboardStatistic::SOURCE_YOUTUBE)
                        ->where('is_auto_updated', true)
                        ->first();

                    if ($stat) {
                        $stat->updateValue((string) number_format($subscribers, 0, '', ' '));
                        $this->info("  ✓ YouTube подписчики: {$subscribers}");
                    }
                } else {
                    $this->warn('  ⚠ Не удалось получить количество подписчиков YouTube');
                }
            }
        } catch (\Exception $e) {
            $this->error("  ✗ Ошибка обновления YouTube: {$e->getMessage()}");
            Log::error('Dashboard Update YouTube Error', ['error' => $e->getMessage()]);
        }
    }
}