<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Принудительно https только если приложение реально отдаётся по https.
        // Локально на http asset()/url() генерируют http-ссылки (иначе стили не грузятся).
        if (str_starts_with(config('app.url'), 'https://')) {
            URL::forceScheme('https');
            URL::forceRootUrl(config('app.url'));
        }

        // Для ngrok отключаем secure cookies
        if (str_contains(config('app.url'), 'ngrok-free.dev')) {
            config(['session.secure' => false]);
        }
        

        if (config('app.debug')) {
            DB::listen(function ($query) {
                if ($query->time > 100) {
                    Log::debug('Slow SQL (>100ms): ' . substr($query->sql, 0, 100) . ' (' . $query->time . 'ms)');
                }
            });
        }
    }
}