<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Reference data first: nothing else works without the incubation steps,
        // the BMC blocks and the team positions.
        $this->call(ReferenceDataSeeder::class);
        $this->call(AdminSeeder::class);

        // Demo accounts, useful locally but not something to run on a live
        // database. `--class=DemoAccountsSeeder` runs them on purpose.
        if (app()->environment('local')) {
            $this->call(DemoAccountsSeeder::class);
        }
    }
}
