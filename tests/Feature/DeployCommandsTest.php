<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

/**
 * Runs the exact artisan commands docker/php/entrypoint.sh runs on every
 * container start. `config:cache` is deliberately excluded and asserted to
 * still fail: config/navigation.php stores real Closures (the sidebar's
 * per-item `when` visibility checks), and config:cache works by
 * var_export-ing the whole merged config array, which cannot represent a
 * Closure. That combination first surfaced as a crash-looping production
 * container — nginx returning 502 because php-fpm never got far enough in
 * the entrypoint to start — rather than as a caught local failure.
 */
class DeployCommandsTest extends TestCase
{
    /** @test */
    public function route_cache_succeeds(): void
    {
        try {
            $exitCode = Artisan::call('route:cache');
            $this->assertSame(0, $exitCode, Artisan::output());
        } finally {
            Artisan::call('route:clear');
        }
    }

    /** @test */
    public function view_cache_succeeds(): void
    {
        try {
            $exitCode = Artisan::call('view:cache');
            $this->assertSame(0, $exitCode, Artisan::output());
        } finally {
            Artisan::call('view:clear');
        }
    }

    /**
     * Documents the known limitation rather than letting it resurface as a
     * silent production incident. If this test starts failing because
     * config:cache now SUCCEEDS (no exception thrown), that is good news:
     * delete this test and add config:cache back to docker/php/entrypoint.sh.
     *
     * @test
     */
    public function config_cache_is_known_to_fail_because_navigation_config_holds_closures(): void
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Your configuration files are not serializable.');

        try {
            Artisan::call('config:cache');
        } finally {
            Artisan::call('config:clear');
        }
    }
}
