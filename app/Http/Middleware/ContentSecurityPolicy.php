<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ContentSecurityPolicy
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Ambil config
        $cspConfig = config('csp.policy');

        // Build CSP string
        $directives = [];
        foreach ($cspConfig as $directive => $sources) {
            $directives[] = $directive . ' ' . implode(' ', $sources);
        }

        $cspHeader = implode('; ', $directives);

        // Tambahkan header CSP
        $response->headers->set('Content-Security-Policy', $cspHeader);

        return $response;
    }
}
