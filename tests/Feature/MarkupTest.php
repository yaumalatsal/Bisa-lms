<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Investor;
use App\Models\Mentor;
use App\Models\Siswa;
use Database\Seeders\ReferenceDataSeeder;
use DOMDocument;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

/**
 * Renders every page and checks the HTML actually holds together.
 *
 * This is what catches the class of problem the app was full of: a second
 * <html> document nested inside the layout, ids reused across a page so
 * getElementById picks the wrong node, and forms closing inside their own
 * modal footer.
 */
class MarkupTest extends TestCase
{
    use RefreshDatabase;

    /** Ids Blade renders from data; duplicates there are the data's doing. */
    private const DYNAMIC_ID = '/^\d+$/';

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(ReferenceDataSeeder::class);
        $this->seedFixtures();
    }

    /** @test */
    public function every_page_is_a_single_well_formed_document(): void
    {
        $problems = [];

        foreach ($this->pages() as $path => $html) {
            foreach ([
                'html' => substr_count($html, '<html'),
                'body' => substr_count($html, '<body'),
                'doctype' => substr_count($html, '<!DOCTYPE'),
            ] as $tag => $count) {
                if ($count !== 1) {
                    $problems[] = "$path: found $count <$tag> (expected 1)";
                }
            }
        }

        $this->assertSame([], $problems, implode("\n", $problems));
    }

    /** @test */
    public function no_page_reuses_an_element_id(): void
    {
        $problems = [];

        foreach ($this->pages() as $path => $html) {
            $doc = $this->parse($html);
            $seen = [];

            foreach ((new \DOMXPath($doc))->query('//*[@id]') as $node) {
                $id = $node->getAttribute('id');
                if ($id === '' || preg_match(self::DYNAMIC_ID, $id)) {
                    continue;
                }
                $seen[$id] = ($seen[$id] ?? 0) + 1;
            }

            foreach (array_filter($seen, fn ($n) => $n > 1) as $id => $n) {
                $problems[] = "$path: id=\"$id\" appears $n times";
            }
        }

        $this->assertSame([], $problems, implode("\n", $problems));
    }

    /** @test */
    public function forms_and_modals_nest_correctly(): void
    {
        $problems = [];

        foreach ($this->pages() as $path => $html) {
            $doc = $this->parse($html);
            $xpath = new \DOMXPath($doc);

            // A modal footer that ended up outside its form means the source
            // closed </form> too early and the parser resolved it differently.
            foreach ($xpath->query('//form') as $form) {
                $submits = $xpath->query('.//button[@type="submit"] | .//input[@type="submit"]', $form);
                $method = strtoupper($form->getAttribute('method') ?: 'GET');

                // A form driven from JavaScript (a confirm dialog that calls
                // .submit()) legitimately has no submit control of its own.
                $jsDriven = $form->getAttribute('data-submitted-by') === 'js';

                if ($method === 'POST' && $submits->length === 0 && ! $jsDriven) {
                    $problems[] = "$path: a POST form has no submit control inside it";
                }
            }

            // Every POST form must carry a CSRF token or Laravel will 419.
            foreach ($xpath->query('//form[translate(@method,"post","POST")="POST"]') as $form) {
                if ($xpath->query('.//input[@name="_token"]', $form)->length === 0) {
                    $action = $form->getAttribute('action') ?: '(current url)';
                    $problems[] = "$path: POST form to $action has no CSRF token";
                }
            }
        }

        $this->assertSame([], $problems, implode("\n", $problems));
    }

    /** @test */
    public function every_input_has_an_accessible_name(): void
    {
        $problems = [];

        foreach ($this->pages() as $path => $html) {
            $xpath = new \DOMXPath($this->parse($html));

            foreach ($xpath->query('//input[not(@type="hidden")] | //select | //textarea') as $field) {
                $id = $field->getAttribute('id');
                $named = $field->getAttribute('aria-label')
                    || $field->getAttribute('aria-labelledby')
                    || $field->getAttribute('placeholder')
                    || $field->getAttribute('title')
                    || ($id && $xpath->query(sprintf('//label[@for="%s"]', $id))->length)
                    || $xpath->query('ancestor::label', $field)->length;

                if (! $named) {
                    $problems[] = sprintf(
                        '%s: <%s name="%s"> has no label',
                        $path,
                        $field->nodeName,
                        $field->getAttribute('name') ?: '?'
                    );
                }
            }
        }

        $this->assertSame([], $problems, implode("\n", $problems));
    }

    private function parse(string $html): DOMDocument
    {
        $doc = new DOMDocument;
        libxml_use_internal_errors(true);
        $doc->loadHTML('<?xml encoding="utf-8" ?>'.$html);
        libxml_clear_errors();

        return $doc;
    }

    /**
     * Render one page per GET route, as the role that owns it.
     *
     * @return array<string, string>
     */
    private function pages(): array
    {
        static $cache = null;
        if ($cache !== null) {
            return $cache;
        }

        $subs = [
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

        $pages = [];

        foreach (Route::getRoutes() as $route) {
            if (! in_array('GET', $route->methods(), true)) {
                continue;
            }
            if (preg_match('~^(_ignition|api/|telescope)~', $route->uri())) {
                continue;
            }

            $path = '/'.rtrim(strtr($route->uri(), $subs), '/');
            $role = $this->roleFor($route->gatherMiddleware());

            $response = $role
                ? $this->actingAs($users[$role], $role)->withSession($this->sessionFor($role))->get($path)
                : $this->get($path);

            // Only HTML pages; some routes legitimately return JSON.
            $isHtml = str_contains((string) $response->headers->get('content-type'), 'text/html');

            if ($response->getStatusCode() === 200 && $isHtml) {
                $pages[$path] = $response->getContent();
            }
        }

        return $cache = $pages;
    }

    private function roleFor(array $middleware): ?string
    {
        foreach ($middleware as $m) {
            if ($m === 'auth.role:siswa') {
                return 'siswa';
            }
            if ($m === 'auth.role:mentor') {
                return 'mentor';
            }
            if ($m === 'auth:admin') {
                return 'admin';
            }
            if ($m === 'auth:investor') {
                return 'investor';
            }
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
        $siswaId = Siswa::create(['nomor_induk' => '1001', 'password' => Hash::make('secret123'), 'tanggal_lahir' => '2000-01-01', 'nama' => 'Siti Rahayu'])->id;
        DB::table('mentor')->insert(['id' => 1, 'nama' => 'Dr Andi', 'email' => 'mentor@test.local', 'password' => md5('x'), 'nomor_telepon' => '08123', 'umur' => 40, 'instansi' => 'UM']);
        DB::table('admins')->insert(['id' => 1, 'nama' => 'Admin', 'email' => 'admin@test.local', 'password' => Hash::make('secret123')]);
        DB::table('investors')->insert(['id' => 1, 'nama' => 'Investor', 'email' => 'investor@test.local', 'password' => Hash::make('secret123'), 'nomor_telepon' => '0812']);

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
            ['id' => 1, 'product_id' => 1, 'total_sales' => 50, 'report_date' => date('Y').'-01-15', 'revenue' => 5000000, 'spending' => 2000000, 'status' => 'disetujui', 'user_id' => $siswaId],
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
        DB::table('feedback')->insert(['id' => 1, 'id_step' => 1, 'judul' => 'Bagus', 'komentar' => 'lanjutkan', 'id_produk' => 1, 'id_mentor' => 1]);
        DB::table('penilaian')->insert(['id' => 1, 'id_produk' => 1, 'id_step' => 1, 'id_mentor' => 1, 'file_nilai' => 80, 'keterangan' => 'baik']);
        DB::table('messages')->insert(['id' => 1, 'id_product' => 1, 'id_siswa' => $siswaId, 'message' => 'halo']);
    }
}
