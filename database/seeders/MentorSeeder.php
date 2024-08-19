<?php

namespace Database\Seeders;

use App\Models\Mentor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MentorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Mentor::create([
            'nama' => 'mentor1',
            'email' => 'mentor1@gmail.com',
            'password' => md5('12345678'),
            'nomor_telepon' => '0812123456789',
            'umur' => '35',
            'instansi' => 'Universitas Negeri Malang',
        ]);
        Mentor::create([
            'nama' => 'mentor2',
            'email' => 'mentor2@gmail.com',
            'password' => md5('12345678'),
            'nomor_telepon' => '0812987654321',
            'umur' => '38',
            'instansi' => 'Universitas Negeri Malang',
        ]);
    }
}
