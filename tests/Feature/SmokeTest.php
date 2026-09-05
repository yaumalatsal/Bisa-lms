<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Investor;
use App\Models\Mentor;
use App\Models\Siswa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Requests every GET route as the role that owns it and asserts it does not
 * blow up. Complements the more focused tests: this is the net that catches a
 * view referencing a variable a controller no longer passes.
 */
class SmokeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedFixtures();
    }

    /** @test */
    public function every_get_route_renders_for_its_role(): void
    {
        $substitutions = [
            '{id}' => '1', '{id_bmc}' => '1', '{id_produk}' => '1', '{product_id}' => '1',
            '{course}' => '1', '{courseId}' => '1', '{course_id}' => '1', '{courseid}' => '1',
            '{material}' => '1', '{materialId}' => '1', '{mapelId}' => '1', '{mapel_id}' => '1',
            '{soalId}' => '1', '{question}' => '1', '{answerId}' => '1', '{id_product}' => '1',
        ];

        $users = [
            'siswa' => Siswa::first(),
            'mentor' => Mentor::find(1),
            'admin' => Admin::find(1),
            'investor' => Investor::find(1),
        ];

        $failures = [];

        foreach (Route::getRoutes() as $route) {
            if (! in_array('GET', $route->methods(), true)) {
                continue;
            }

            $uri = $route->uri();
            if (preg_match('~^(_ignition|api/|telescope)~', $uri)) {
                continue;
            }

            $path = '/' . rtrim(strtr($uri, $substitutions), '/');
            $role = $this->roleFor($route->gatherMiddleware());

            $request = $this->withoutExceptionHandling();

            try {
                $response = $role
                    ? $this->actingAs($users[$role], $role)->withSession($this->sessionFor($role))->get($path)
                    : $this->get($path);

                $status = $response->getStatusCode();
                if ($status >= 400) {
                    $failures[] = "$status  $path";
                }
            } catch (\Throwable $e) {
                $failures[] = sprintf('EXC  %-40s %s: %s', $path, class_basename($e), $e->getMessage());
            }
        }

        $this->assertSame([], $failures, "Routes that failed:\n" . implode("\n", $failures));
    }

    private function roleFor(array $middleware): ?string
    {
        foreach ($middleware as $m) {
            if ($m === 'auth.role:siswa') return 'siswa';
            if ($m === 'auth.role:mentor') return 'mentor';
            if ($m === 'auth:admin') return 'admin';
            if ($m === 'auth:investor') return 'investor';
        }

        return null;
    }

    private function sessionFor(string $role): array
    {
        return match ($role) {
            'siswa' => ['id_siswa' => Siswa::first()->id, 'id_produk' => 1, 'track' => 1, 'track_status' => 1],
            'mentor' => ['id_mentor' => 1],
            default => [],
        };
    }

    private function seedFixtures(): void
    {
        // Auto-increment ids are not reset between tests in a transaction, so
        // capture the real id rather than assuming 1.
        $siswaId = Siswa::create(['nomor_induk' => '1001', 'password' => Hash::make('secret123'), 'tanggal_lahir' => '2000-01-01', 'nama' => 'Siti Rahayu'])->id;
        DB::table('mentor')->insert(['id' => 1, 'nama' => 'Dr Andi', 'email' => 'mentor@test.local', 'password' => md5('legacy123'), 'nomor_telepon' => '08123', 'umur' => 40, 'instansi' => 'UM']);
        DB::table('admins')->insert(['id' => 1, 'nama' => 'Admin', 'email' => 'admin@test.local', 'password' => Hash::make('secret123')]);
        DB::table('investors')->insert(['id' => 1, 'nama' => 'Investor', 'email' => 'investor@test.local', 'password' => Hash::make('secret123'), 'nomor_telepon' => '0812']);

        DB::table('position')->insert([['id' => 1, 'posisi' => 'Hustler'], ['id' => 2, 'posisi' => 'Hipster'], ['id' => 3, 'posisi' => 'Hacker']]);
        DB::table('master_step')->insert([
            ['id' => 1, 'step_number' => 1, 'nama_step' => 'Abstrak', 'route' => '/product_abstract', 'deskripsi' => 'x', 'gambar' => 'a.png'],
            ['id' => 2, 'step_number' => 2, 'nama_step' => 'Tim', 'route' => '/tahap_team', 'deskripsi' => 'x', 'gambar' => 'b.png'],
        ]);
        DB::table('master_bmc')->insert([['id' => 1, 'judul' => 'Value Proposition', 'deskripsi' => 'Nilai', 'icon' => 'x', 'route' => '/detail_bmc/1', 'video' => '-']]);
        DB::table('pertanyaan_bmc')->insert([['id' => 1, 'pertanyaan' => 'Apa nilainya?', 'keterangan' => 'ket', 'id_poin_bmc' => 1]]);

        DB::table('product')->insert(['id' => 1, 'nama_produk' => 'Kopi Kita', 'deskripsi' => 'Kopi lokal', 'id_mentor' => 1, 'id_ceo' => $siswaId]);
        DB::table('member')->insert(['id' => 1, 'id_siswa' => $siswaId, 'id_produk' => 1, 'position' => 1]);
        DB::table('track_step')->insert(['id' => 1, 'id_ceo' => $siswaId, 'id_produk' => 1, 'id_step' => 1, 'status' => 1]);
        DB::table('jawaban_bmc')->insert(['id' => 1, 'jawaban' => 'Kopi murah', 'id_produk' => 1, 'id_siswa' => $siswaId, 'id_pertanyaan' => 1]);
        DB::table('logo_produk')->insert(['id' => 1, 'logo_produk' => 'x.png', 'id_produk' => 1, 'deskripsi' => 'logo']);
        DB::table('protolink')->insert(['id' => 1, 'link_figma' => 'https://figma.com/x', 'id_produk' => 1]);
        DB::table('video_produk')->insert(['id' => 1, 'link_video' => 'https://youtu.be/dQw4w9WgXcQ', 'id_produk' => 1]);
        DB::table('poster_produk')->insert(['id' => 1, 'poster_produk' => 'p.png', 'id_produk' => 1]);
        DB::table('presentasi')->insert(['id' => 1, 'deck' => 'https://slides.com/x', 'id_produk' => 1]);
        DB::table('monthly_reports')->insert([
            ['id' => 1, 'product_id' => 1, 'total_sales' => 50, 'report_date' => date('Y') . '-01-15', 'revenue' => 5000000, 'spending' => 2000000, 'status' => 'disetujui', 'user_id' => $siswaId],
            ['id' => 2, 'product_id' => 1, 'total_sales' => 30, 'report_date' => (date('Y') - 1) . '-02-15', 'revenue' => 3000000, 'spending' => 1000000, 'status' => 'disetujui', 'user_id' => $siswaId],
        ]);
        DB::table('mapels_quiz')->insert(['id' => 1, 'name' => 'Kewirausahaan', 'durasi' => 30]);
        DB::table('quiz_soals')->insert(['id' => 1, 'mapel_id' => 1, 'question' => 'Apa itu BMC?', 'option_a' => 'a', 'option_b' => 'b', 'option_c' => 'c', 'option_d' => 'd', 'key' => 'a']);
        DB::table('quiz_hasils')->insert(['id' => 1, 'user_id' => $siswaId, 'mapel_id' => 1, 'nilai' => 80, 'nilai_terakhir' => 80]);
        DB::table('artikel_inkubasis')->insert(['id' => 1, 'judul' => 'BMC 101', 'kategori' => 'bmc', 'bentuk_kategori' => 'artikel', 'link' => 'https://x.test/a', 'thumbnail' => 't.png']);
        DB::table('courses')->insert(['id' => 1, 'title' => 'Dasar Bisnis', 'description' => 'x', 'mentor_id' => 1, 'status' => 1, 'image' => 'c.png']);
        DB::table('course_materials')->insert(['id' => 1, 'course_id' => 1, 'title' => 'Materi 1', 'content' => 'isi', 'status' => 1]);
        DB::table('course_questions')->insert(['id' => 1, 'course_id' => 1, 'question_text' => 'Kenapa?']);
        DB::table('course_answers')->insert(['id' => 1, 'question_id' => 1, 'siswa_id' => $siswaId, 'answer_text' => 'Karena', 'score' => 90]);
        DB::table('course_completions')->insert(['id' => 1, 'course_id' => 1, 'siswa_id' => $siswaId, 'completed' => 1, 'score' => 90]);
        DB::table('rankings')->insert(['name' => 'Tim A', 'score' => 90]);
        DB::table('feedback')->insert(['id' => 1, 'id_step' => 1, 'judul' => 'Bagus', 'komentar' => 'lanjutkan', 'id_produk' => 1, 'id_mentor' => 1]);
        DB::table('penilaian')->insert(['id' => 1, 'id_produk' => 1, 'id_step' => 1, 'id_mentor' => 1, 'file_nilai' => 80, 'keterangan' => 'baik']);
        DB::table('messages')->insert(['id' => 1, 'id_product' => 1, 'id_siswa' => $siswaId, 'message' => 'halo']);
    }
}
