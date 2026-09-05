<?php

namespace Tests\Feature;

use App\Models\Mentor;
use App\Models\Siswa;
use App\Support\LegacyPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function siswa_area_rejects_guests_instead_of_rendering_the_page(): void
    {
        // The page used to render in full and then redirect from a <script> tag,
        // which meant the data was already in the response body.
        $this->get('/produk')->assertRedirect('/login');
        $this->get('/monitoring')->assertRedirect('/login');
        $this->get('/laporan')->assertRedirect('/login');
    }

    /** @test */
    public function mentor_area_rejects_guests(): void
    {
        // These had no server-side protection at all.
        $this->get('/mentor')->assertRedirect('/mentor/login');
        $this->get('/mentor/produk')->assertRedirect('/mentor/login');
        $this->get('/mentor/penilaian')->assertRedirect('/mentor/login');
        $this->get('/mentor/laporan-produk')->assertRedirect('/mentor/login');
    }

    /** @test */
    public function a_siswa_cannot_reach_the_mentor_area(): void
    {
        $siswa = Siswa::create([
            'nomor_induk' => '2001', 'password' => Hash::make('secret123'),
            'tanggal_lahir' => '2000-01-01', 'nama' => 'Rina',
        ]);

        $this->actingAs($siswa, 'siswa')->get('/mentor/produk')->assertRedirect('/mentor/login');
    }

    /** @test */
    public function a_legacy_md5_sha1_siswa_password_still_works_and_is_upgraded_to_bcrypt(): void
    {
        $plain = 'rahasia123';

        $siswa = Siswa::create([
            'nomor_induk' => '3001',
            'password' => md5($plain).sha1($plain),
            'tanggal_lahir' => '2000-01-01',
            'nama' => 'Legacy Siswa',
        ]);

        $this->post('/signin', ['nis' => '3001', 'password' => $plain])
            ->assertRedirect();

        $this->assertAuthenticatedAs($siswa->fresh(), 'siswa');

        $stored = $siswa->fresh()->password;
        $this->assertTrue(LegacyPassword::isModern($stored), 'password should have been rehashed to bcrypt');
        $this->assertTrue(Hash::check($plain, $stored));
    }

    /** @test */
    public function a_legacy_md5_mentor_password_still_works_and_is_upgraded(): void
    {
        $plain = 'rahasia123';

        DB::table('mentor')->insert([
            'id' => 1, 'nama' => 'Legacy Mentor', 'email' => 'legacy@test.local',
            'password' => md5($plain), 'nomor_telepon' => '08', 'umur' => 30, 'instansi' => 'UM',
        ]);

        $this->post('/mentor/signin', ['email' => 'legacy@test.local', 'password' => $plain])
            ->assertRedirect('/mentor');

        $this->assertAuthenticated('mentor');
        $this->assertTrue(LegacyPassword::isModern(Mentor::find(1)->password));
    }

    /** @test */
    public function a_bcrypt_password_keeps_working_after_the_upgrade(): void
    {
        Siswa::create([
            'nomor_induk' => '4001', 'password' => Hash::make('secret123'),
            'tanggal_lahir' => '2000-01-01', 'nama' => 'Modern',
        ]);

        $this->post('/signin', ['nis' => '4001', 'password' => 'secret123'])->assertRedirect();
        $this->assertAuthenticated('siswa');
    }

    /** @test */
    public function a_wrong_password_is_rejected(): void
    {
        Siswa::create([
            'nomor_induk' => '5001', 'password' => Hash::make('secret123'),
            'tanggal_lahir' => '2000-01-01', 'nama' => 'Modern',
        ]);

        $this->from('/login')
            ->post('/signin', ['nis' => '5001', 'password' => 'wrong'])
            ->assertRedirect('/login')
            ->assertSessionHasErrors('nis');

        $this->assertGuest('siswa');
    }

    /** @test */
    public function registration_stores_a_bcrypt_hash_not_md5(): void
    {
        $this->post('/pendaftaran_siswa', [
            'nama_siswa' => 'Baru', 'nis' => '6001',
            'password' => 'secret123', 'ttl' => '2001-05-05',
        ])->assertRedirect('/login');

        $stored = Siswa::where('nomor_induk', '6001')->value('password');

        $this->assertTrue(LegacyPassword::isModern($stored));
        $this->assertNotSame(md5('secret123').sha1('secret123'), $stored);
    }
}
