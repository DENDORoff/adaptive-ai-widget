<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CacheResponse
{
    public function handle(Request $request, Closure $next, int $minutes = 60): Response
    {
        if (!$request->isMethod('GET')) {
            return $next($request);
        }

        if (auth()->check()) {
            return $next($request);
        }

        if ($request->is('admin/*')) {
            return $next($request);
        }

        $key = $this->getCacheKey($request);

        if (Cache::has($key)) {
            return $this->withNoStore(response(Cache::get($key)))
                ->header('X-Cache-Hit', 'true');
        }

        $response = $next($request);

        if ($response->status() === 200) {
            Cache::put($key, $response->content(), now()->addMinutes($minutes));
            $response->header('X-Cache-Hit', 'false');
        }

        return $this->withNoStore($response);
    }

    protected function getCacheKey(Request $request): string
    {
        $locale = app()->getLocale();
        return 'page_cache:' . $locale . ':' . md5($request->fullUrl());
    }

    /**
     * Браузер не должен копить страницы сайта, иначе первые полчаса
     * выглядят как «изменения из админки не подтягиваются».
     */
    protected function withNoStore(Response $response): Response
    {
        return $response->header('Cache-Control', 'no-store, private, max-age=0');
    }

    /**
     * Инвалидация целых страниц при редактировании контента из админки.
     * Не трогает сайт-онлайн (site.online) и прочие временные ключи.
     */
    public static function clearPageCache(): void
    {
        $store = Cache::getStore();

        if ($store instanceof \Illuminate\Cache\DatabaseStore) {
            $table = (string) config('cache.stores.database.table', 'cache');
            $prefix = (string) config('cache.prefix', '');
            try {
                DB::table($table)->where('key', 'like', $prefix . 'page_cache:%')->delete();
                return;
            } catch (\Throwable $e) {
                // если таблицы нет — фолбэк ниже
            }
        }

        Cache::flush();
    }
}