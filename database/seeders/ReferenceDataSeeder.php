<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Reference data the application cannot function without.
 *
 * `master_step`, `master_bmc`, `pertanyaan_bmc` and `position` drive the whole
 * incubation flow, yet none of them were seeded — a freshly migrated database
 * had no steps for a student to work through and no BMC questions to answer.
 *
 * Idempotent: safe to run repeatedly, and it will not overwrite rows an admin
 * has since edited through the admin panel (only missing ids are inserted).
 */
class ReferenceDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedPositions();
        $this->seedSteps();
        $this->seedBmc();
    }

    private function seedPositions(): void
    {
        // Position 1 is treated as the CEO/"hustler" throughout the codebase.
        $this->insertMissing('position', [
            ['id' => 1, 'posisi' => 'Hustler (CEO)'],
            ['id' => 2, 'posisi' => 'Hipster'],
            ['id' => 3, 'posisi' => 'Hacker'],
        ]);
    }

    /**
     * The step ids matter: BmcController, ProtoController, PublikasiController
     * and PresentasiController write id_step 3, 4, 5 and 6 respectively when a
     * stage is submitted, and SiswaController redirects to `route` after login.
     */
    private function seedSteps(): void
    {
        $this->insertMissing('master_step', [
            [
                'id' => 1, 'step_number' => 1, 'nama_step' => 'Abstrak Produk',
                'route' => '/product_abstract', 'gambar' => 'alur1.png',
                'deskripsi' => 'Definisikan secara singkat produkmu dan pilih mentor pendamping.',
            ],
            [
                'id' => 2, 'step_number' => 2, 'nama_step' => 'Pembentukan Tim',
                'route' => '/tahap_team', 'gambar' => 'alur2.png',
                'deskripsi' => 'Ajak Hipster dan Hacker untuk melengkapi tim hebatmu.',
            ],
            [
                'id' => 3, 'step_number' => 3, 'nama_step' => 'Model Bisnis',
                'route' => '/bmc', 'gambar' => 'alur3.png',
                'deskripsi' => 'Susun konsep model bisnis menggunakan Business Model Canvas.',
            ],
            [
                'id' => 4, 'step_number' => 4, 'nama_step' => 'Logo dan Prototype',
                'route' => '/proto', 'gambar' => 'alur4.png',
                'deskripsi' => 'Buat prototype dan logo produkmu.',
            ],
            [
                'id' => 5, 'step_number' => 5, 'nama_step' => 'Publikasi Produk',
                'route' => '/publikasi', 'gambar' => 'ilustration/step/publis.gif',
                'deskripsi' => 'Siapkan video dan poster sebagai luaran publikasi produk.',
            ],
            [
                'id' => 6, 'step_number' => 6, 'nama_step' => 'Presentasi Produk',
                'route' => '/presentasi', 'gambar' => 'ilustration/step/presen.gif',
                'deskripsi' => 'Susun file presentasi (pitch deck) produkmu.',
            ],
        ]);
    }

    private function seedBmc(): void
    {
        // [id, judul, icon, deskripsi, [pertanyaan => keterangan, ...]]
        // Ids, titles and icons match the live installation so an existing
        // database and a fresh one describe the same nine blocks.
        $blocks = [
            [1, 'Value Proposition (Proposisi Nilai)', 'alur1.png',
                'Nilai yang kamu tawarkan sehingga pelanggan memilih produkmu dibanding yang lain.', [
                    'Masalah pelanggan apa yang produkmu selesaikan?' => 'Jelaskan masalah nyata yang dirasakan pelanggan.',
                    'Apa yang membuat produkmu berbeda?' => 'Bandingkan dengan pilihan lain yang sudah ada di pasar.',
                ]],
            [2, 'Customer Segments (Segmentasi Pelanggan)', 'alur2.png',
                'Kelompok orang atau organisasi yang ingin kamu layani.', [
                    'Untuk siapa produk ini dibuat?' => 'Sebutkan kelompok pelanggan yang paling utama.',
                    'Siapa pelanggan terpentingmu?' => 'Kelompok yang paling menentukan keberlanjutan bisnis.',
                ]],
            [3, 'Customer Relationships (Hubungan Pelanggan)', 'bmc3.png',
                'Hubungan yang kamu bangun dan jaga dengan setiap segmen pelanggan.', [
                    'Bagaimana kamu menjaga pelanggan tetap kembali?' => 'Program langganan, komunitas, layanan purnajual.',
                    'Bagaimana kamu menangani keluhan?' => 'Kanal dan waktu tanggap yang kamu janjikan.',
                ]],
            [4, 'Channels (Penyaluran)', 'bmc4.png',
                'Jalur yang menghubungkan produkmu sampai ke tangan pelanggan.', [
                    'Bagaimana pelanggan mengetahui produkmu?' => 'Media sosial, bazar kampus, mulut ke mulut, dan lainnya.',
                    'Bagaimana produk dikirim atau diakses?' => 'Jalur penjualan dan pengiriman yang kamu pakai.',
                ]],
            [5, 'Key Activities (Aktivitas Utama)', 'bmc5.png',
                'Kegiatan yang wajib berjalan agar nilai produkmu sampai ke pelanggan.', [
                    'Kegiatan apa yang wajib dilakukan setiap hari?' => 'Produksi, pemasaran, distribusi, layanan pelanggan.',
                    'Siapa yang bertanggung jawab?' => 'Bagi tugas antara Hustler, Hipster dan Hacker.',
                ]],
            [6, 'Key Resources (Sumber Daya Utama)', 'bmc6.png',
                'Sumber daya yang harus kamu miliki agar aktivitas utama bisa berjalan.', [
                    'Sumber daya apa yang paling penting?' => 'Bahan baku, alat, tempat, keahlian tim, modal.',
                    'Mana yang belum kamu miliki?' => 'Tuliskan rencana untuk memenuhinya.',
                ]],
            [7, 'Key Partners (Mitra)', 'bmc7.png',
                'Pemasok dan pihak luar yang kamu andalkan untuk menjalankan bisnis.', [
                    'Siapa pemasok dan mitra utamamu?' => 'Sebutkan pihak di luar tim yang kamu andalkan.',
                    'Apa yang kamu dapat dari mereka?' => 'Bahan, jaringan, tempat, atau keahlian.',
                ]],
            [8, 'Cost Structures (Biaya Operasional)', 'bmc8.png',
                'Seluruh biaya yang timbul dari menjalankan model bisnismu.', [
                    'Biaya terbesar dalam bisnismu apa?' => 'Pisahkan biaya tetap dan biaya variabel.',
                    'Bagaimana kamu menekan biaya itu?' => 'Langkah nyata yang sudah atau akan kamu ambil.',
                ]],
            [9, 'Revenue Streams (Keuntungan)', 'bmc9.png',
                'Cara model bisnismu berubah menjadi pemasukan.', [
                    'Untuk apa pelanggan bersedia membayar?' => 'Produk, jasa, langganan, atau lainnya.',
                    'Berapa harga yang kamu tetapkan dan mengapa?' => 'Kaitkan dengan biaya dan daya beli pelanggan.',
                ]],
        ];

        $bmcRows = [];
        foreach ($blocks as [$id, $judul, $icon, $deskripsi, $questions]) {
            $bmcRows[] = [
                'id' => $id,
                'judul' => $judul,
                'deskripsi' => $deskripsi,
                'icon' => $icon,
                'route' => '/detail_bmc/'.$id,
                'video' => '-',
            ];
        }
        $this->insertMissing('master_bmc', $bmcRows);

        // Only seed questions for BMC points that have none, so an admin's own
        // questions are never duplicated.
        foreach ($blocks as [$id, , , , $questions]) {
            if (DB::table('pertanyaan_bmc')->where('id_poin_bmc', $id)->exists()) {
                continue;
            }

            DB::table('pertanyaan_bmc')->insert(
                collect($questions)->map(fn ($keterangan, $pertanyaan) => [
                    'pertanyaan' => $pertanyaan,
                    'keterangan' => $keterangan,
                    'id_poin_bmc' => $id,
                ])->values()->all()
            );
        }
    }

    /**
     * Insert only the rows whose id is not present yet.
     *
     * @param  array<int, array<string, mixed>>  $rows
     */
    private function insertMissing(string $table, array $rows): void
    {
        $existing = DB::table($table)->pluck('id')->all();

        $missing = array_values(array_filter(
            $rows,
            fn ($row) => ! in_array($row['id'], $existing)
        ));

        if ($missing) {
            DB::table($table)->insert($missing);
        }
    }
}
