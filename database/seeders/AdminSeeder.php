<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // The default password used to be literally "1". It now comes from the
        // environment so a deployment can set its own, and the seeder is
        // idempotent rather than failing on a second run.
        Admin::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@bisa.test')],
            [
                'nama' => 'Administrator',
                'password' => Hash::make(env('ADMIN_PASSWORD', 'ubah-password-ini')),
            ]
        );

        $this->command?->warn('Admin seeded. Ganti passwordnya sebelum dipakai di server.');
    }
}
