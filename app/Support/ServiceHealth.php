<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * Point-in-time checks for the monitor API.
 *
 * Every check is wrapped: a monitor that 500s the moment one dependency is
 * having a bad day is a monitor that tells you nothing on the one day you
 * actually needed it. Each method always returns a result — "down" with a
 * reason, never an exception.
 */
class ServiceHealth
{
    /**
     * One line per dependency: name => ['status' => 'ok'|'down', ...detail].
     *
     * @return array<string, array<string, mixed>>
     */
    public function checks(): array
    {
        return [
            'database' => $this->database(),
            'cache' => $this->cache(),
            'queue' => $this->queue(),
            'storage' => $this->storage(),
            'session' => $this->session(),
        ];
    }

    /**
     * True only if every check above reports ok.
     */
    public function allHealthy(): bool
    {
        foreach ($this->checks() as $check) {
            if (($check['status'] ?? 'down') !== 'ok') {
                return false;
            }
        }

        return true;
    }

    private function database(): array
    {
        $start = microtime(true);

        try {
            DB::connection()->select('select 1');

            return [
                'status' => 'ok',
                'driver' => config('database.default'),
                'latency_ms' => (int) round((microtime(true) - $start) * 1000),
            ];
        } catch (Throwable $e) {
            return ['status' => 'down', 'error' => $e->getMessage()];
        }
    }

    private function cache(): array
    {
        try {
            $key = 'monitor:probe';
            cache()->put($key, true, 5);
            $ok = cache()->get($key) === true;

            return [
                'status' => $ok ? 'ok' : 'down',
                'driver' => config('cache.default'),
            ];
        } catch (Throwable $e) {
            return ['status' => 'down', 'error' => $e->getMessage()];
        }
    }

    private function queue(): array
    {
        // `sync` has no backlog to inspect; report the configured driver so a
        // switch to a real queue is visible without this endpoint changing.
        try {
            return [
                'status' => 'ok',
                'driver' => config('queue.default'),
            ];
        } catch (Throwable $e) {
            return ['status' => 'down', 'error' => $e->getMessage()];
        }
    }

    private function storage(): array
    {
        try {
            $path = storage_path('app');
            $free = @disk_free_space($path);
            $total = @disk_total_space($path);

            if ($free === false || $total === false || $total === 0) {
                return ['status' => 'down', 'error' => 'disk_free_space unavailable'];
            }

            $usedPct = round((1 - $free / $total) * 100, 1);

            return [
                'status' => $usedPct < 95 ? 'ok' : 'down',
                'disk_used_pct' => $usedPct,
                'disk_free_mb' => (int) round($free / 1048576),
            ];
        } catch (Throwable $e) {
            return ['status' => 'down', 'error' => $e->getMessage()];
        }
    }

    private function session(): array
    {
        try {
            $driver = config('session.driver');

            if ($driver === 'file') {
                $writable = is_writable(storage_path('framework/sessions'));

                return ['status' => $writable ? 'ok' : 'down', 'driver' => $driver];
            }

            return ['status' => 'ok', 'driver' => $driver];
        } catch (Throwable $e) {
            return ['status' => 'down', 'error' => $e->getMessage()];
        }
    }

    /**
     * A stable identifier for "what is currently deployed", read from the
     * commit the deploy step writes at build time. Falls back gracefully when
     * running outside that pipeline (local dev).
     */
    public static function deployedRevision(): ?string
    {
        $file = base_path('REVISION');

        if (is_file($file)) {
            return trim(file_get_contents($file)) ?: null;
        }

        return null;
    }
}
