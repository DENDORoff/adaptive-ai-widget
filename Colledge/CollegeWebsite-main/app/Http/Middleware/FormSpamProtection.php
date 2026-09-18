<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;


class FormSpamProtection
{
    private const RATE_LIMIT_MINUTES = 5;
    private const MAX_REQUESTS_PER_IP = 10; 
    private const MAX_REQUESTS_PER_EMAIL = 5; 
    private const DUPLICATE_CHECK_MINUTES = 2; 


    public function handle(Request $request, Closure $next)
    {

        if (!$request->isMethod('POST')) {
            return $next($request);
        }
        

        if ($this->isHoneypotFilled($request)) {
            Log::warning('Honeypot field filled', [
                'ip' => $this->getClientIp($request),
                'route' => $request->route()->getName(),
                'timestamp' => now(),
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Произошла ошибка при обработке формы. Попробуйте позже.'
            ], 429);
        }


        if ($this->isRateLimitedByIp($request)) {
            Log::warning('Rate limit exceeded by IP', [
                'ip' => $this->getClientIp($request),
                'route' => $request->route()->getName(),
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Вы отправляете слишком много запросов. Пожалуйста, подождите несколько минут.'
            ], 429);
        }


        if ($request->filled('email') && $this->isRateLimitedByEmail($request)) {
            Log::warning('Rate limit exceeded by email', [
                'email' => $request->input('email'),
                'ip' => $this->getClientIp($request),
                'route' => $request->route()->getName(),
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Этот email отправил слишком много запросов. Пожалуйста, подождите некоторое время.'
            ], 429);
        }


        if ($this->isDuplicateSubmission($request)) {
            Log::warning('Duplicate submission detected', [
                'ip' => $this->getClientIp($request),
                'email' => $request->input('email'),
                'route' => $request->route()->getName(),
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Эта форма уже была отправлена. Пожалуйста, не отправляйте её снова.'
            ], 429);
        }


        $this->incrementRateLimits($request);

        return $next($request);
    }


    private function isHoneypotFilled(Request $request): bool
    {

        return $request->filled('website_url') || $request->filled('confirm_bot');
    }


    private function isRateLimitedByIp(Request $request): bool
    {
        $ip = $this->getClientIp($request);
        $key = "form_spam:ip:{$ip}:" . $request->route()->getName();
        
        $count = Cache::get($key, 0);
        return $count >= self::MAX_REQUESTS_PER_IP;
    }


    private function isRateLimitedByEmail(Request $request): bool
    {
        $email = strtolower(trim($request->input('email', '')));
        $key = "form_spam:email:{$email}:" . $request->route()->getName();
        
        $count = Cache::get($key, 0);
        return $count >= self::MAX_REQUESTS_PER_EMAIL;
    }


    private function isDuplicateSubmission(Request $request): bool
    {
        $email = strtolower(trim($request->input('email', '')));
        if (empty($email)) {
            return false;
        }

        $message = $request->input('message') ?? $request->input('description') ?? '';
        $hash = md5($email . $message);
        $key = "form_duplicate:{$hash}:" . $request->route()->getName();
        
        if (Cache::has($key)) {
            return true;
        }


        Cache::put($key, true, now()->addMinutes(self::DUPLICATE_CHECK_MINUTES));
        
        return false;
    }


    private function incrementRateLimits(Request $request): void
    {
        $routeName = $request->route()->getName();
        $ttl = self::RATE_LIMIT_MINUTES * 60;

        $ipKey = "form_spam:ip:{$this->getClientIp($request)}:{$routeName}";
        if (Cache::has($ipKey)) {
            Cache::increment($ipKey, 1);
        } else {
            Cache::put($ipKey, 1, $ttl);
        }
        

        if ($request->filled('email')) {
            $email = strtolower(trim($request->input('email')));
            $emailKey = "form_spam:email:{$email}:{$routeName}";
            if (Cache::has($emailKey)) {
                Cache::increment($emailKey, 1);
            } else {
                Cache::put($emailKey, 1, 30 * 60); 
            }
        }
    }


    private function getClientIp(Request $request): string
    {

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $ip = trim($ips[0]);
        } else {
            $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        }


        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            return $ip;
        }

        return $request->ip() ?? '0.0.0.0';
    }
}
