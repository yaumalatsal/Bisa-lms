<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;

/**
 * Cache-busted URLs for the first-party CSS and JS.
 *
 * These files are referenced by a plain path, so a browser that has seen an
 * older copy will keep serving it from cache — a palette change can ship and
 * simply not appear. Appending the file's modification time gives every edit a
 * new URL without any build step.
 */
class Asset
{
    /**
     * asset() plus a ?v= stamp derived from the file's mtime.
     */
    public static function versioned(string $path): string
    {
        return asset($path).'?v='.static::version($path);
    }

    /**
     * The stamp for one file. Looked up once per request in production, where
     * the filesystem is stable; always fresh locally so edits show up.
     */
    public static function version(string $path): string
    {
        $resolve = function () use ($path) {
            $full = public_path($path);

            return is_file($full) ? (string) filemtime($full) : '0';
        };

        if (app()->environment('production')) {
            return Cache::remember('asset-version:'.$path, 3600, $resolve);
        }

        return $resolve();
    }
}
