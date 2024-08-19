<?php

namespace Database\Seeders;

use App\Models\Siswa;
use Database\Factories\SiswaFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Siswa::factory()->count(10)->create();
    }
}
