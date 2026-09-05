<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Telescope is a require-dev package and auto-discovery is disabled for
        // it in composer.json, so register it by hand and never in production.
        // Previously it was a production dependency listening to every request.
        if ($this->app->environment('local', 'testing') && class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(\App\Providers\TelescopeServiceProvider::class);
        }
    }

    public function boot(): void
    {
        // Pagination markup that matches the design system rather than
        // Tailwind, which this app does not load.
        Paginator::useBootstrapFive();

        // Behind a load balancer or tunnel the app otherwise emits http:// URLs
        // on an https:// page, which browsers block as mixed content.
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
