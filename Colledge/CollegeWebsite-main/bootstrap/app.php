<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\SetLocale;
use App\Http\Middleware\CorsMiddleware;
use App\Http\Middleware\SecurityHeaders;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api(prepend: [
            CorsMiddleware::class,
        ]);


        $middleware->web(append: [
            SetLocale::class,
        ]);


        $middleware->trustProxies(at: '*');
        

        $middleware->validateCsrfTokens(except: [
            'livewire/upload-file',
            'livewire/*',
            'api/chat/*',
        ]);


        $middleware->appendToGroup('web', [
            SecurityHeaders::class,
        ]);


        $middleware->alias([
            'throttle.forms' => \App\Http\Middleware\ThrottleFormSubmissions::class,
            'cache.response' => \App\Http\Middleware\CacheResponse::class,
            'admin.ip' => \App\Http\Middleware\RestrictAdminAccess::class,
            'honeypot' => \App\Http\Middleware\HoneypotProtection::class,
            'spam.protection' => \App\Http\Middleware\FormSpamProtection::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {

    })->create();