<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SiteAdminToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = env('SITE_ADMIN_TOKEN', '');
        $got = $request->header('X-Site-Token', '');

        if ($token === '' || !hash_equals($token, $got)) {
            abort(403, 'forbidden');
        }

        return $next($request);
    }
}