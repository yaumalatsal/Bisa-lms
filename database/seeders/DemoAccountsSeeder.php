<?php

namespace Database\Seeders;

use App\Models\Mentor;
use App\Models\Siswa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Sample mentor and student accounts for local development.
 *
 * The previous MentorSeeder stored md5 hashes; everything is bcrypt now.
 */
class DemoAccountsSeeder extends Seeder
{
    private const PASSWORD = 'password123';

    public function run(): void
    {
        foreach ([
            ['mentor1@bisa.test', 'Dr. Rina Kusuma', '081200000001', 35],
            ['mentor2@bisa.test', 'Bpk. Adi Nugroho', '081200000002', 38],
        ] as [$email, $nama, $telepon, $umur]) {
            Mentor::updateOrCreate(['email' => $email], [
                'nama' => $nama,
                'password' => Hash::make(self::PASSWORD),
                'nomor_telepon' => $telepon,
                'umur' => $umur,
                'instansi' => 'Universitas Negeri Malang',
            ]);
        }

        foreach ([
            ['210001', 'Siti Rahayu'],
            ['210002', 'Budi Santoso'],
            ['210003', 'Dewi Lestari'],
        ] as [$nis, $nama]) {
            Siswa::updateOrCreate(['nomor_induk' => $nis], [
                'nama' => $nama,
                'password' => Hash::make(self::PASSWORD),
                'tanggal_lahir' => '2003-01-01',
            ]);
        }

        $this->command?->info('Demo login: mentor1@bisa.test / NIS 210001 — password "'.self::PASSWORD.'"');
    }
}
