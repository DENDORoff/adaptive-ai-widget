<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HoneypotProtection
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->filled('website') || $request->filled('url_field')) {
            abort(422, 'Spam detected');
        }

        return $next($request);
    }
}