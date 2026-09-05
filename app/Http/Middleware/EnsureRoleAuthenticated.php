<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Server-side gate for the siswa and mentor areas.
 *
 * These areas used to be "protected" only by an inline <script> redirect in the
 * Blade layout, which meant the full page (and its data) was rendered and sent
 * to anyone who asked. This middleware rejects the request before a controller
 * ever runs.
 *
 * It also backfills the legacy session keys that the older controllers still
 * read (`id_siswa`, `id_mentor`), so the authenticated guard stays the single
 * source of truth even for code that has not been migrated yet.
 */
class EnsureRoleAuthenticated
{
    /**
     * Where each guard sends unauthenticated visitors.
     */
    private const LOGIN_ROUTES = [
        'siswa' => '/login',
        'mentor' => '/mentor/login',
        'investor' => '/investor/login',
        'admin' => '/admin/login',
    ];

    /**
     * Legacy session key holding the signed-in id, per guard.
     */
    private const SESSION_ID_KEYS = [
        'siswa' => 'id_siswa',
        'mentor' => 'id_mentor',
    ];

    public function handle(Request $request, Closure $next, string $guard = 'siswa')
    {
        if (! Auth::guard($guard)->check()) {
            return $this->unauthenticated($request, $guard);
        }

        if ($key = self::SESSION_ID_KEYS[$guard] ?? null) {
            $request->session()->put($key, Auth::guard($guard)->id());
        }

        return $next($request);
    }

    private function unauthenticated(Request $request, string $guard)
    {
        if ($request->expectsJson()) {
            abort(401, 'Unauthenticated.');
        }

        return redirect()
            ->guest(self::LOGIN_ROUTES[$guard] ?? '/login')
            ->with('login_error', 'Silakan login terlebih dahulu.');
    }
}
