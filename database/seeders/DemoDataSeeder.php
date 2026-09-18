<?php

namespace Database\Seeders;

use App\Models\Investor;
use App\Models\Mentor;
use App\Models\MonthlyReport;
use App\Models\Product;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Demonstration data for the public instance.
 *
 *     php artisan db:seed --class=DemoDataSeeder
 *
 * The public instance exists to be looked at. Empty, every panel reads zero
 * and a visitor cannot tell a working incubation platform from an unfinished
 * one. This fills it with a cohort of student ventures and a year of their
 * monthly reports.
 *
 * Not for production. It refuses to run when products already exist.
 *
 * The shape of the data is the point. Ventures were not all founded on the
 * same day, they do not all file every month, revenue is not a smooth line,
 * and a real approval queue always has something pending and something
 * rejected. Flat, complete, uniform data reads as generated immediately.
 */
class DemoDataSeeder extends Seeder
{
    /** Student ventures: name, what it does, and roughly how it trades. */
    private const VENTURES = [
        ['Kopi Kenangan Kampus', 'Kedai kopi mahasiswa dengan biji lokal Jawa Timur', 2_800_000, 0.22],
        ['BatikIn', 'Batik tulis modern untuk pasar anak muda', 4_100_000, 0.31],
        ['SayurBox Mahasiswa', 'Titip beli sayur harian untuk kos dan kontrakan', 1_900_000, 0.18],
        ['Rajut Nusantara', 'Kerajinan rajut tangan, penjualan daring', 1_450_000, 0.26],
        ['TeknikIn', 'Jasa servis elektronik dan laptop kampus', 3_200_000, 0.35],
        ['EduPlay', 'Mainan edukasi kayu untuk PAUD', 2_300_000, 0.28],
        ['Katering Sehat Bu Sri', 'Katering harian rendah kalori', 5_600_000, 0.19],
        ['Hidroponik Kita', 'Sayur hidroponik untuk restoran lokal', 2_050_000, 0.24],
        ['Sablon Satuan', 'Sablon kaos satuan untuk organisasi kampus', 3_750_000, 0.29],
        ['Daur Ulang Kreatif', 'Tas dan dompet dari limbah plastik', 1_200_000, 0.33],
    ];

    private const MENTORS = [
        ['Dr. Andi Wijaya', 'andi.wijaya@bisa.test', 'Fakultas Ekonomi', 44],
        ['Rina Kusuma, M.M.', 'rina.kusuma@bisa.test', 'Inkubator Bisnis', 38],
        ['Bayu Santoso, S.T.', 'bayu.santoso@bisa.test', 'Fakultas Teknik', 41],
        ['Sari Handayani, M.Sc.', 'sari.handayani@bisa.test', 'Pusat Kewirausahaan', 36],
    ];

    private const INVESTORS = [
        ['Mitra Ventura Nusantara', 'kontak@mitraventura.test'],
        ['Angel Fund Surabaya', 'invest@angelsby.test'],
        ['Koperasi Modal Mahasiswa', 'admin@kmm.test'],
    ];

    private const FIRST = ['Budi', 'Siti', 'Agus', 'Dewi', 'Rian', 'Putri', 'Eko', 'Rina', 'Joko', 'Ayu', 'Fajar', 'Nadia'];
    private const LAST = ['Santoso', 'Wijaya', 'Pratama', 'Lestari', 'Nugroho', 'Handayani', 'Saputra', 'Maulana'];

    public function run(): void
    {
        if (Product::count() > 0) {
            $this->command?->warn('Products already exist — skipping so real data is never doubled.');

            return;
        }

        // Deterministic, so a screenshot taken today still matches next month.
        mt_srand(20260918);

        DB::transaction(function () {
            $mentors = $this->seedMentors();
            $this->seedInvestors();
            $students = $this->seedStudents();
            $products = $this->seedProducts($mentors, $students);
            $this->seedReports($products);
        });

        $this->command?->info(sprintf(
            'Seeded %d siswa, %d mentor, %d investor, %d produk, %d laporan.',
            Siswa::count(),
            Mentor::count(),
            Investor::count(),
            Product::count(),
            MonthlyReport::count(),
        ));
    }

    /** @return array<int, Mentor> */
    private function seedMentors(): array
    {
        $out = [];

        foreach (self::MENTORS as [$nama, $email, $instansi, $umur]) {
            $out[] = Mentor::firstOrCreate(
                ['email' => $email],
                [
                    'nama' => $nama,
                    'password' => Hash::make('demo1234'),
                    'nomor_telepon' => $this->phone(),
                    'umur' => $umur,
                    'instansi' => $instansi,
                ],
            );
        }

        return $out;
    }

    private function seedInvestors(): void
    {
        foreach (self::INVESTORS as [$nama, $email]) {
            Investor::firstOrCreate(
                ['email' => $email],
                [
                    'nama' => $nama,
                    'password' => Hash::make('demo1234'),
                    'nomor_telepon' => $this->phone(),
                ],
            );
        }
    }

    /**
     * A cohort. More students than ventures, because not everyone founds one —
     * which is what an incubator's own numbers look like.
     *
     * @return array<int, Siswa>
     */
    private function seedStudents(): array
    {
        $out = [];

        for ($i = 0; $i < 34; $i++) {
            $nama = self::FIRST[mt_rand(0, count(self::FIRST) - 1)]
                . ' ' . self::LAST[mt_rand(0, count(self::LAST) - 1)];

            $out[] = Siswa::firstOrCreate(
                ['nomor_induk' => sprintf('2260%04d', 1001 + $i)],
                [
                    'nama' => $nama,
                    'password' => Hash::make('demo1234'),
                    'tanggal_lahir' => Carbon::now()
                        ->subYears(mt_rand(18, 23))
                        ->subDays(mt_rand(0, 364))
                        ->toDateString(),
                ],
            );
        }

        return $out;
    }

    /** @return array<int, array{0: Product, 1: int, 2: float, 3: Carbon, 4: Siswa}> */
    private function seedProducts(array $mentors, array $students): array
    {
        $out = [];

        foreach (self::VENTURES as $i => [$nama, $deskripsi, $baseline, $margin]) {
            $product = Product::create([
                'nama_produk' => $nama,
                'deskripsi' => $deskripsi,
                'id_mentor' => $mentors[$i % count($mentors)]->id,
                'id_ceo' => $students[$i]->id,
            ]);

            // Staggered intake: ventures joined the programme at different
            // points, so their reporting histories are different lengths.
            $founded = Carbon::now()->subMonths(mt_rand(4, 14))->startOfMonth();

            $out[] = [$product, $baseline, $margin, $founded, $students[$i]];
        }

        return $out;
    }

    /**
     * Monthly reports, one per venture per month since it joined.
     *
     * Revenue drifts rather than stepping evenly, some months are skipped
     * because founders miss deadlines, and the most recent month is mostly
     * still pending — which is what makes an approval queue worth rendering.
     */
    private function seedReports(array $products): void
    {
        // user_id is the student who filed the report.
        //
        // MonthlyReport::user() declares belongsTo(User::class), but this
        // install has no users table at all -- it authenticates through siswa,
        // mentor, investors and admins. Calling that relation would fatal.
        // The column is the venture's CEO, which is what the data means.
        foreach ($products as [$product, $baseline, $margin, $founded, $ceo]) {
            $month = $founded->copy();
            $trend = 1.0;

            while ($month->lt(Carbon::now()->startOfMonth()->addMonth())) {
                // Roughly one month in eight is simply never filed.
                if (mt_rand(1, 100) <= 12) {
                    $month->addMonth();
                    continue;
                }

                $trend *= 1 + (mt_rand(-12, 22) / 100);
                $trend = max(0.45, min($trend, 3.2));

                $revenue = (int) round($baseline * $trend);
                $spending = (int) round($revenue * (1 - $margin) * (1 + mt_rand(-8, 8) / 100));

                MonthlyReport::create([
                    'product_id' => $product->id,
                    'user_id' => $ceo->id,
                    'report_date' => $month->copy()->endOfMonth()->toDateString(),
                    'total_sales' => max(1, (int) round($revenue / mt_rand(15_000, 45_000))),
                    'revenue' => $revenue,
                    'spending' => $spending,
                    'status' => $this->statusFor($month),
                ]);

                $month->addMonth();
            }
        }
    }

    /**
     * Older months have been dealt with; the current one mostly has not.
     * A queue where everything is approved shows nothing worth looking at.
     */
    private function statusFor(Carbon $month): string
    {
        $isCurrent = $month->isSameMonth(Carbon::now());
        $roll = mt_rand(1, 100);

        if ($isCurrent) {
            return $roll <= 70 ? MonthlyReport::STATUS_PENDING : MonthlyReport::STATUS_APPROVED;
        }

        return match (true) {
            $roll <= 78 => MonthlyReport::STATUS_APPROVED,
            $roll <= 92 => MonthlyReport::STATUS_REJECTED,
            default => MonthlyReport::STATUS_PENDING,
        };
    }


    private function phone(): string
    {
        return '08' . mt_rand(11, 59) . mt_rand(1000000, 9999999);
    }
}
