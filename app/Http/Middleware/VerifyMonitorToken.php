<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Gate for /api/monitor/*.
 *
 * Accepts the token as `Authorization: Bearer <token>` or `X-Monitor-Token`,
 * so it works with a generic HTTP client either way. Compared with
 * hash_equals(): a monitor polls this endpoint every few seconds forever, so a
 * timing side-channel here is exactly the kind of thing that is cheap to leak
 * and expensive to have leaked.
 */
class VerifyMonitorToken
{
    public function handle(Request $request, Closure $next)
    {
        $expected = (string) config('monitor.token');

        if ($expected === '') {
            return response()->json([
                'error' => 'monitoring_disabled',
                'message' => 'No MONITOR_API_TOKEN is set on this install.',
            ], 503);
        }

        $given = (string) ($request->bearerToken() ?: $request->header('X-Monitor-Token', ''));

        if ($given === '' || ! hash_equals($expected, $given)) {
            return response()->json([
                'error' => 'unauthorized',
                'message' => 'Missing or invalid monitor token.',
            ], 401);
        }

        return $next($request);
    }
}
