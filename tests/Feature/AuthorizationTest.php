<?php

namespace Tests\Feature;

use App\Models\Mentor;
use App\Models\Siswa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * Two teams, two mentors. Every case here was previously possible: the
 * controllers took the target id straight from the request without checking
 * that the signed-in user had anything to do with it.
 */
class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    private Siswa $ceoA;

    private Siswa $ceoB;

    private Siswa $anggotaB;

    protected function setUp(): void
    {
        parent::setUp();

        $this->ceoA = $this->siswa('1001', 'CEO A');
        $this->ceoB = $this->siswa('1002', 'CEO B');
        $this->anggotaB = $this->siswa('1003', 'Anggota B');

        DB::table('mentor')->insert([
            ['id' => 1, 'nama' => 'Mentor A', 'email' => 'a@t.local', 'password' => md5('x'), 'nomor_telepon' => '1', 'umur' => 30, 'instansi' => 'UM'],
            ['id' => 2, 'nama' => 'Mentor B', 'email' => 'b@t.local', 'password' => md5('x'), 'nomor_telepon' => '2', 'umur' => 31, 'instansi' => 'UM'],
        ]);

        DB::table('position')->insert([
            ['id' => 1, 'posisi' => 'Hustler'], ['id' => 2, 'posisi' => 'Hipster'], ['id' => 3, 'posisi' => 'Hacker'],
        ]);
        DB::table('master_step')->insert([
            ['id' => 1, 'step_number' => 1, 'nama_step' => 'Abstrak', 'route' => '/product_abstract', 'deskripsi' => 'x', 'gambar' => 'a.png'],
        ]);
        DB::table('master_bmc')->insert(['id' => 1, 'judul' => 'VP', 'deskripsi' => 'd', 'icon' => 'i', 'route' => '/r', 'video' => '-']);
        DB::table('pertanyaan_bmc')->insert(['id' => 1, 'pertanyaan' => 'Q', 'keterangan' => 'k', 'id_poin_bmc' => 1]);

        // Produk 1 -> tim A (mentor 1); Produk 2 -> tim B (mentor 2).
        DB::table('product')->insert([
            ['id' => 1, 'nama_produk' => 'Produk A', 'deskripsi' => 'a', 'id_mentor' => 1, 'id_ceo' => $this->ceoA->id],
            ['id' => 2, 'nama_produk' => 'Produk B', 'deskripsi' => 'b', 'id_mentor' => 2, 'id_ceo' => $this->ceoB->id],
        ]);
        DB::table('member')->insert([
            ['id' => 1, 'id_siswa' => $this->ceoA->id, 'id_produk' => 1, 'position' => 1],
            ['id' => 2, 'id_siswa' => $this->ceoB->id, 'id_produk' => 2, 'position' => 1],
            ['id' => 3, 'id_siswa' => $this->anggotaB->id, 'id_produk' => 2, 'position' => 2],
        ]);
        DB::table('track_step')->insert([
            ['id' => 1, 'id_ceo' => $this->ceoA->id, 'id_produk' => 1, 'id_step' => 1, 'status' => 0],
            ['id' => 2, 'id_ceo' => $this->ceoB->id, 'id_produk' => 2, 'id_step' => 1, 'status' => 0],
        ]);
    }

    /** @test */
    public function a_ceo_cannot_delete_a_member_of_another_team(): void
    {
        $this->actingAs($this->ceoA, 'siswa')
            ->withSession(['id_siswa' => $this->ceoA->id, 'id_produk' => 1])
            ->delete('/delete_member/3')
            ->assertRedirect('/tahap_team');

        $this->assertDatabaseHas('member', ['id' => 3]);
    }

    /** @test */
    public function a_ceo_can_delete_a_member_of_their_own_team(): void
    {
        DB::table('member')->insert(['id' => 4, 'id_siswa' => $this->siswa('1004', 'Anggota A')->id, 'id_produk' => 1, 'position' => 2]);

        $this->actingAs($this->ceoA, 'siswa')
            ->withSession(['id_siswa' => $this->ceoA->id, 'id_produk' => 1])
            ->delete('/delete_member/4')
            ->assertRedirect('/tahap_team');

        $this->assertDatabaseMissing('member', ['id' => 4]);
    }

    /** @test */
    public function a_ceo_cannot_be_deleted_from_their_own_team(): void
    {
        $this->actingAs($this->ceoA, 'siswa')
            ->withSession(['id_siswa' => $this->ceoA->id, 'id_produk' => 1])
            ->delete('/delete_member/1');

        $this->assertDatabaseHas('member', ['id' => 1]);
    }

    /** @test */
    public function a_ceo_cannot_add_members_to_another_teams_product(): void
    {
        $outsider = $this->siswa('1005', 'Luar');

        $this->actingAs($this->ceoA, 'siswa')
            ->withSession(['id_siswa' => $this->ceoA->id, 'id_produk' => 1])
            ->post('/tambah_member', ['id_siswa' => $outsider->id, 'id_produk' => 2, 'position' => 3])
            ->assertRedirect('/tahap_team');

        $this->assertDatabaseMissing('member', ['id_siswa' => $outsider->id, 'id_produk' => 2]);
    }

    /** @test */
    public function a_siswa_cannot_write_bmc_answers_into_another_teams_product(): void
    {
        // The form used to submit id_produk and id_siswa as hidden fields.
        $this->actingAs($this->ceoA, 'siswa')
            ->withSession(['id_siswa' => $this->ceoA->id, 'id_produk' => 2])
            ->post('/update_jawaban', ['id_pertanyaan' => 1, 'jawaban' => 'disusupi']);

        $this->assertDatabaseMissing('jawaban_bmc', ['id_produk' => 2, 'jawaban' => 'disusupi']);
    }

    /** @test */
    public function a_siswa_can_write_bmc_answers_for_their_own_product(): void
    {
        $this->actingAs($this->ceoA, 'siswa')
            ->withSession(['id_siswa' => $this->ceoA->id, 'id_produk' => 1])
            ->post('/update_jawaban', ['id_pertanyaan' => 1, 'jawaban' => 'jawaban sah']);

        $this->assertDatabaseHas('jawaban_bmc', ['id_produk' => 1, 'jawaban' => 'jawaban sah']);
    }

    /** @test */
    public function a_mentor_cannot_change_the_track_of_a_product_they_do_not_supervise(): void
    {
        $this->actingAs(Mentor::find(1), 'mentor')
            ->withSession(['id_mentor' => 1])
            ->post('/mentor/editTrack', [
                'id_track' => 2, 'id_produk' => 2, 'step' => 1, 'status' => 2,
            ]);

        $this->assertDatabaseHas('track_step', ['id' => 2, 'status' => 0]);
    }

    /** @test */
    public function a_mentor_can_change_the_track_of_their_own_product(): void
    {
        $this->actingAs(Mentor::find(1), 'mentor')
            ->withSession(['id_mentor' => 1])
            ->post('/mentor/editTrack', [
                'id_track' => 1, 'id_produk' => 1, 'step' => 1, 'status' => 2,
            ]);

        $this->assertDatabaseHas('track_step', ['id' => 1, 'status' => 2]);
    }

    /** @test */
    public function a_mentor_cannot_read_another_teams_group_chat(): void
    {
        $this->actingAs(Mentor::find(1), 'mentor')
            ->withSession(['id_mentor' => 1])
            ->get('/mentor/groupchat/2')
            ->assertForbidden();
    }

    /** @test */
    public function a_siswa_cannot_post_into_another_teams_group_chat(): void
    {
        $this->actingAs($this->ceoA, 'siswa')
            ->withSession(['id_siswa' => $this->ceoA->id, 'id_produk' => 1])
            ->post('/groupchat/2', ['message' => 'halo'])
            ->assertForbidden();

        $this->assertDatabaseMissing('messages', ['id_product' => 2]);
    }

    /** @test */
    public function a_mentor_cannot_approve_a_report_for_another_mentors_product(): void
    {
        DB::table('monthly_reports')->insert([
            'id' => 1, 'product_id' => 2, 'user_id' => $this->ceoB->id, 'total_sales' => 10,
            'report_date' => '2026-01-01', 'revenue' => 100, 'spending' => 50, 'status' => 'pending',
        ]);

        $this->actingAs(Mentor::find(1), 'mentor')
            ->withSession(['id_mentor' => 1])
            ->post('/mentor/laporan_produk/approve/1')
            ->assertNotFound();

        $this->assertDatabaseHas('monthly_reports', ['id' => 1, 'status' => 'pending']);
    }

    /** @test */
    public function a_siswa_cannot_open_or_delete_another_teams_monthly_report(): void
    {
        DB::table('monthly_reports')->insert([
            'id' => 1, 'product_id' => 2, 'user_id' => $this->ceoB->id, 'total_sales' => 10,
            'report_date' => '2026-01-01', 'revenue' => 100, 'spending' => 50, 'status' => 'pending',
        ]);

        $session = ['id_siswa' => $this->ceoA->id, 'id_produk' => 1];

        $this->actingAs($this->ceoA, 'siswa')->withSession($session)
            ->get('/laporan/edit/1')->assertNotFound();

        $this->actingAs($this->ceoA, 'siswa')->withSession($session)
            ->delete('/laporan/1')->assertNotFound();

        $this->assertDatabaseHas('monthly_reports', ['id' => 1]);
    }

    /** @test */
    public function editing_an_approved_report_sends_it_back_for_review(): void
    {
        DB::table('monthly_reports')->insert([
            'id' => 2, 'product_id' => 1, 'user_id' => $this->ceoA->id, 'total_sales' => 10,
            'report_date' => '2026-01-01', 'revenue' => 100, 'spending' => 50, 'status' => 'disetujui',
        ]);

        $this->actingAs($this->ceoA, 'siswa')
            ->withSession(['id_siswa' => $this->ceoA->id, 'id_produk' => 1])
            ->put('/laporan/update/2', [
                'product_id' => 1, 'total_sales' => 999,
                'revenue' => 9999, 'spending' => 1, 'report_date' => '2026-01-01',
            ])->assertRedirect(route('dashboard.laporan.index'));

        $this->assertDatabaseHas('monthly_reports', [
            'id' => 2, 'total_sales' => 999, 'status' => 'pending',
        ]);
    }

    /** @test */
    public function a_report_cannot_be_attached_to_another_teams_product(): void
    {
        DB::table('monthly_reports')->insert([
            'id' => 3, 'product_id' => 1, 'user_id' => $this->ceoA->id, 'total_sales' => 10,
            'report_date' => '2026-01-01', 'revenue' => 100, 'spending' => 50, 'status' => 'pending',
        ]);

        $this->actingAs($this->ceoA, 'siswa')
            ->withSession(['id_siswa' => $this->ceoA->id, 'id_produk' => 1])
            ->put('/laporan/update/3', [
                'product_id' => 2, 'total_sales' => 10,
                'revenue' => 100, 'spending' => 50, 'report_date' => '2026-01-01',
            ])->assertSessionHasErrors('product_id');

        $this->assertDatabaseHas('monthly_reports', ['id' => 3, 'product_id' => 1]);
    }

    private function siswa(string $nis, string $nama): Siswa
    {
        return Siswa::create([
            'nomor_induk' => $nis,
            'password' => Hash::make('secret123'),
            'tanggal_lahir' => '2000-01-01',
            'nama' => $nama,
        ]);
    }
}
