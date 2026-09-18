<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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
            return response(Cache::get($key))
                ->header('X-Cache-Hit', 'true');
        }

        $response = $next($request);

        if ($response->status() === 200) {
            Cache::put($key, $response->content(), now()->addMinutes($minutes));
            $response->header('X-Cache-Hit', 'false');
        }

        return $response;
    }

    protected function getCacheKey(Request $request): string
    {
        $locale = app()->getLocale();
        return 'page_cache:' . $locale . ':' . md5($request->fullUrl());
    }
}