<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ThrottleFormSubmissions
{
    protected $limiter;

    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    public function handle(Request $request, Closure $next, int $maxAttempts = 10, int $decayMinutes = 10): Response
    {

        if (!$request->isMethod('POST') && !$request->isMethod('PUT') 
            && !$request->isMethod('PATCH') && !$request->isMethod('DELETE')) {
            return $next($request);
        }

        $key = $this->resolveRequestSignature($request);


        \Log::debug('Throttle check', [
            'ip' => $request->ip(),
            'path' => $request->path(),
            'method' => $request->method(),
            'key' => $key,
            'attempts' => $this->limiter->attempts($key),
            'user_id' => $request->user()?->id,
        ]);

        if ($this->limiter->tooManyAttempts($key, $maxAttempts)) {
            $seconds = $this->limiter->availableIn($key);
            

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => "Слишком много попыток. Пожалуйста, попробуйте через " . ceil($seconds / 60) . " минут.",
                    'retry_after' => $seconds
                ], 429);
            }
            

            return back()
                ->withInput()
                ->withErrors([
                    'throttle' => "Слишком много попыток отправки формы. Пожалуйста, попробуйте через " . ceil($seconds / 60) . " минут."
                ])
                ->with('status', 'too-many-attempts');
        }


        $this->limiter->hit($key, $decayMinutes * 60);

        $response = $next($request);
        
        return $response;
    }

    protected function resolveRequestSignature(Request $request): string
    {
        return sha1(
            $request->ip() . '|' . 
            $request->path() . '|' . 
            $request->method() . '|' .
            ($request->user()?->id ?: 'guest')
        );
    }
}