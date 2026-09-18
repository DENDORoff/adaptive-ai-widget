<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestrictAdminAccess
{
    protected $allowedIps = [
        '127.0.0.1',
        '::1',
        // 'ВАШ_IP_АДРЕС', // Добавьте свой IP
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $clientIp = $request->ip();
        
        if (!in_array($clientIp, $this->allowedIps)) {
            \Log::warning('Unauthorized admin access attempt', [
                'ip' => $clientIp,
                'url' => $request->fullUrl(),
                'user_agent' => $request->userAgent(),
                'time' => now(),
            ]);
            
            abort(403, 'Доступ к админ-панели запрещен с вашего IP адреса.');
        }

        return $next($request);
    }
}