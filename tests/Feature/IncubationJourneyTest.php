<?php

namespace Tests\Feature;

use App\Models\Mentor;
use App\Models\Siswa;
use Database\Seeders\ReferenceDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * Walks a student through the whole incubation flow on a freshly seeded
 * database, then has the mentor review the result.
 *
 * This is the test that would have caught the fact that a fresh install had no
 * master_step or master_bmc rows at all, so there was nothing to work through.
 */
class IncubationJourneyTest extends TestCase
{
    use RefreshDatabase;

    private Siswa $siswa;

    private Mentor $mentor;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(ReferenceDataSeeder::class);

        $this->mentor = Mentor::create([
            'nama' => 'Dr. Rina', 'email' => 'rina@bisa.test',
            'password' => Hash::make('password123'),
            'nomor_telepon' => '0812', 'umur' => 40, 'instansi' => 'UM',
        ]);
    }

    /** @test */
    public function the_reference_data_a_fresh_install_needs_is_present(): void
    {
        $this->assertSame(6, DB::table('master_step')->count(), 'incubation steps');
        $this->assertSame(9, DB::table('master_bmc')->count(), 'BMC blocks');
        $this->assertSame(3, DB::table('position')->count(), 'team positions');
        $this->assertGreaterThan(0, DB::table('pertanyaan_bmc')->count(), 'BMC questions');

        // Every step must point at a route that actually exists.
        foreach (DB::table('master_step')->pluck('route') as $route) {
            $this->assertNotNull(
                app('router')->getRoutes()->match(
                    \Illuminate\Http\Request::create($route, 'GET')
                ),
                "master_step.route $route does not resolve"
            );
        }
    }

    /** @test */
    public function a_student_can_register_log_in_and_complete_the_flow(): void
    {
        // 1. Register and sign in.
        $this->post('/pendaftaran_siswa', [
            'nama_siswa' => 'Siti Rahayu', 'nis' => '210099',
            'password' => 'password123', 'ttl' => '2003-04-05',
        ])->assertRedirect('/login');

        $this->post('/signin', ['nis' => '210099', 'password' => 'password123'])
            ->assertRedirect('/product_abstract');

        $this->siswa = Siswa::where('nomor_induk', '210099')->firstOrFail();
        $this->assertAuthenticatedAs($this->siswa, 'siswa');

        // 2. Register a product — becomes CEO, lands on step 1.
        $this->post('/register_produk', [
            'nama_produk' => 'Kopi Kita',
            'deskripsi' => 'Kopi robusta lokal siap seduh.',
            'mentor' => $this->mentor->id,
        ])->assertRedirect('/');

        $product = DB::table('product')->where('nama_produk', 'Kopi Kita')->first();
        $this->assertNotNull($product);
        $this->assertSame($this->siswa->id, (int) $product->id_ceo);
        $this->assertDatabaseHas('member', [
            'id_siswa' => $this->siswa->id, 'id_produk' => $product->id, 'position' => 1,
        ]);
        $this->assertDatabaseHas('track_step', ['id_produk' => $product->id, 'id_step' => 1]);

        $session = ['id_siswa' => $this->siswa->id, 'id_produk' => $product->id];

        // 3. Add a team mate by NIS.
        $mate = Siswa::create([
            'nomor_induk' => '210100', 'nama' => 'Budi',
            'password' => Hash::make('password123'), 'tanggal_lahir' => '2003-01-01',
        ]);

        $this->actor($session)->post('/cari_member', ['nis' => '210100', 'id_produk' => $product->id])
            ->assertRedirect('/tahap_team');

        $this->actor($session)->post('/tambah_member', [
            'id_siswa' => $mate->id, 'id_produk' => $product->id, 'position' => 2,
        ])->assertRedirect('/tahap_team');

        $this->assertDatabaseHas('member', ['id_siswa' => $mate->id, 'id_produk' => $product->id]);

        // 4. Answer a BMC question, then submit the BMC stage.
        $question = DB::table('pertanyaan_bmc')->where('id_poin_bmc', 1)->first();

        $this->actor($session)->post('/update_jawaban', [
            'id_pertanyaan' => $question->id,
            'jawaban' => 'Mahasiswa dan pekerja muda di sekitar kampus.',
        ]);

        $this->assertDatabaseHas('jawaban_bmc', [
            'id_produk' => $product->id, 'id_pertanyaan' => $question->id,
        ]);

        $this->actor($session)->post('/submit_bmc')->assertRedirect('/');
        $this->assertDatabaseHas('track_step', ['id_produk' => $product->id, 'id_step' => 3]);

        // 5. Prototype: figma link + logo upload.
        $this->actor($session)->post('/setFigma', ['link_figma' => 'https://figma.com/file/kopi'])
            ->assertRedirect('/proto');

        $this->actor($session)->post('/setLogo', [
            'logo_produk' => UploadedFile::fake()->image('logo.png', 200, 200),
            'deskripsi' => 'Logo cangkir kopi.',
        ])->assertRedirect('/proto');

        $logo = DB::table('logo_produk')->where('id_produk', $product->id)->first();
        $this->assertNotNull($logo);
        $this->assertStringEndsWith('.png', $logo->logo_produk);
        @unlink(public_path('logo_produk/'.$logo->logo_produk));

        $this->actor($session)->post('/submitProto')->assertRedirect('/');

        // 6. Publication: video + poster.
        $this->actor($session)->post('/setVideo', ['link_video' => 'https://youtu.be/dQw4w9WgXcQ'])
            ->assertRedirect('/publikasi');

        $this->actor($session)->post('/setPoster', [
            'poster_produk' => UploadedFile::fake()->image('poster.jpg', 600, 800),
        ])->assertRedirect('/publikasi');

        $poster = DB::table('poster_produk')->where('id_produk', $product->id)->first();
        $this->assertNotNull($poster);
        @unlink(public_path('poster_produk/'.$poster->poster_produk));

        $this->actor($session)->post('/submitPublikasi')->assertRedirect('/');

        // 7. Pitch deck.
        $this->actor($session)->post('/setPitchDeck', ['deck' => 'https://slides.com/kopi'])
            ->assertRedirect('/presentasi');
        $this->actor($session)->post('/submitDeck')->assertRedirect('/');
        $this->assertDatabaseHas('track_step', ['id_produk' => $product->id, 'id_step' => 6]);

        // 8. Monthly report, then mentor approval.
        $this->actor($session)->post('/laporan', [
            'product_id' => $product->id, 'total_sales' => 40,
            'revenue' => 4_000_000, 'spending' => 1_500_000,
            'report_date' => date('Y').'-06-01',
            'file' => UploadedFile::fake()->create('laporan.pdf', 100, 'application/pdf'),
        ])->assertRedirect(route('dashboard.laporan.index'));

        $report = DB::table('monthly_reports')->where('product_id', $product->id)->first();
        $this->assertSame('pending', $report->status);

        $this->actingAs($this->mentor, 'mentor')->withSession(['id_mentor' => $this->mentor->id])
            ->post('/mentor/laporan_produk/approve/'.$report->id);

        $this->assertDatabaseHas('monthly_reports', ['id' => $report->id, 'status' => 'disetujui']);

        // 9. The approved report now shows up in monitoring for all three roles.
        $this->actor($session)->get('/monitoring')->assertOk()->assertSee('Rp 2.500.000');

        $this->actingAs($this->mentor, 'mentor')->withSession(['id_mentor' => $this->mentor->id])
            ->get('/mentor/pameran/monitoring/'.$product->id)
            ->assertOk()
            ->assertSee('Rp 2.500.000');
    }

    private function actor(array $session)
    {
        return $this->actingAs($this->siswa, 'siswa')->withSession($session);
    }
}
