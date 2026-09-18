<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        // Существующие задачи
        $schedule->command('metrika:sync --days=2')->hourly();
        $schedule->command('dashboard:update-statistics')->hourly();
        
        // ↓↓↓ ДОБАВЬТЕ ЭТИ СТРОКИ ↓↓↓
        
        // Генерация sitemap каждый день в 3:00
        $schedule->command('sitemap:generate')->dailyAt('03:00');
        
        // Бэкап БД каждый день в 2:00 (когда установите spatie/laravel-backup)
        // $schedule->command('backup:run --only-db')->dailyAt('02:00');
        
        // Очистка старых бэкапов (старше 7 дней)
        // $schedule->command('backup:clean')->dailyAt('03:00');
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}