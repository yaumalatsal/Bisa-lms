<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Siswa>
 */
class SiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nama' => fake()->name(),
            // 'email' => fake()->safeEmail(),
            'password' => md5('12345678').sha1('12345678'),
            'nomor_induk' => $this->faker->unique()->numerify('##########'),
            'tanggal_lahir' => $this->faker->date(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
