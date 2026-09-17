<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

/**
 * Prints a random token suitable for MONITOR_API_TOKEN. Only prints — it does
 * not write to .env, since the value has to be copied to whatever is polling
 * this app too (a status console, a deploy check), not just kept locally.
 */
class GenerateMonitorToken extends Command
{
    protected $signature = 'monitor:token';

    protected $description = 'Generate a random token for MONITOR_API_TOKEN';

    public function handle(): int
    {
        $this->line(Str::random(40));

        return self::SUCCESS;
    }
}
