# BISa — Platform Inkubasi & Monitoring Bisnis Mahasiswa

Aplikasi Laravel 9 untuk mendampingi mahasiswa Universitas Negeri Malang menyusun
konsep bisnis, melaporkan perkembangan penjualan, dan mempertemukannya dengan
mentor serta investor.

## Peran

| Peran        | Masuk lewat        | Guard      | Ringkasan |
|--------------|--------------------|------------|-----------|
| **Siswa**    | `/login`           | `siswa`    | Membentuk tim, mengikuti enam tahap inkubasi, mengirim laporan bulanan, mengikuti course dan kuis. |
| **Mentor**   | `/mentor/login`    | `mentor`   | Membimbing produk, memvalidasi tahapan, memberi feedback dan nilai, menyetujui laporan bulanan, mengelola course. |
| **Admin**    | `/admin/login`     | `admin`    | Mengelola produk, siswa, materi, soal kuis dan pertanyaan BMC. |
| **Investor** | `/investor/login`  | `investor` | Menelusuri produk pameran dan monitoring bisnisnya. |

Setiap area dijaga middleware di sisi server (`auth.role:siswa`,
`auth.role:mentor`, `auth:admin`, `auth:investor`).

## Alur inkubasi

Enam tahap, disimpan di tabel `master_step` dan dijalankan berurutan:

| # | Tahap | Rute | Ditandai selesai oleh |
|---|-------|------|------------------------|
| 1 | Abstrak Produk | `/product_abstract` | `ProdukController::registerProduk` |
| 2 | Pembentukan Tim | `/tahap_team` | `TeamController::lock_team` |
| 3 | Model Bisnis (BMC) | `/bmc` | `BmcController::updateTrack` |
| 4 | Logo dan Prototype | `/proto` | `ProtoController::updateTrack` |
| 5 | Publikasi Produk | `/publikasi` | `PublikasiController::updateTrackPublikasi` |
| 6 | Presentasi Produk | `/presentasi` | `PresentasiController::updateTrackDeck` |

Setiap tahap divalidasi mentor lewat `/mentor/detail_produk/{id}`.

## Menjalankan secara lokal

```bash
composer install
cp .env.example .env
php artisan key:generate

# Sesuaikan DB_* di .env, lalu:
php artisan migrate --seed
php artisan storage:link      # laporan bulanan disimpan di disk "public"

php artisan serve
```

`--seed` mengisi data acuan yang wajib ada (tahap inkubasi, sembilan poin BMC
beserta pertanyaannya, dan posisi tim) plus satu akun admin. Di `APP_ENV=local`
seeder juga membuat akun contoh:

| Peran  | Masuk dengan          | Password      |
|--------|-----------------------|---------------|
| Admin  | `admin@bisa.test`     | `ubah-password-ini` (atau `ADMIN_PASSWORD` di `.env`) |
| Mentor | `mentor1@bisa.test`   | `password123` |
| Siswa  | NIS `210001`          | `password123` |

Ganti password admin sebelum dipakai di server.

Unggahan logo dan poster ditulis ke `public/logo_produk` dan
`public/poster_produk`; keduanya diabaikan git (lihat `.gitignore`).

## Pengujian

Suite memakai MySQL karena beberapa migrasi memakai perubahan kolom
doctrine/dbal yang tidak bisa dijalankan SQLite. Buat database kosong lalu
jalankan:

```bash
mysql -e "CREATE DATABASE bisa_test;"    # nama diatur di phpunit.xml
php vendor/bin/phpunit
```

| Berkas | Yang dijaga |
|--------|-------------|
| `tests/Feature/SmokeTest.php` | Setiap rute GET dirender sebagai peran pemiliknya tanpa error. |
| `tests/Feature/MarkupTest.php` | Tiap halaman satu dokumen HTML utuh, tanpa id ganda, form ter-nesting benar dan ber-CSRF, setiap input punya label. |
| `tests/Feature/IncubationJourneyTest.php` | Satu siswa menempuh seluruh alur dari daftar sampai laporan disetujui mentor. |
| `tests/Feature/AuthenticationTest.php` | Penjagaan area per peran, penerimaan password lama dan peningkatannya ke bcrypt. |
| `tests/Feature/AuthorizationTest.php` | Batas antar-tim dan antar-mentor. |
| `tests/Feature/MonitoringStatsTest.php` | Perhitungan statistik monitoring dan jumlah query-nya. |
| `tests/Feature/ErrorPageTest.php` | Halaman 401–503. |
| `tests/Unit/EmbedTest.php` | Penyaringan tautan video dan URL. |

Gaya kode dijaga Laravel Pint:

```bash
php vendor/bin/pint app database routes tests config
```

## Struktur yang perlu diketahui

### Tampilan

Seluruh peran memakai **satu** kerangka halaman:

```
resources/views/layouts/app.blade.php        kerangka aplikasi (topbar + sidebar)
resources/views/layouts/guest.blade.php      kerangka halaman login/registrasi
resources/views/layouts/partials/            topbar, sidebar, flash message
resources/views/errors/                      halaman 401 sampai 503
config/navigation.php                        isi menu tiap peran
public/css/bisa.css                          design system (token, komponen, dark mode)
public/js/bisa.js                            perilaku bersama (tema, sidebar, DataTables)
```

Berkas `resources/views/{dashboard_template,admin,mentor,investor}/template/index.blade.php`
hanya shim tipis yang menyatakan peran mana yang sedang dirender, sehingga view
lama tetap bisa `@extends` ke path yang sama.

Fragmen yang dipakai lintas peran:

```
resources/views/partials/product-detail.blade.php       detail produk (5 peran)
resources/views/partials/monitoring-dashboard.blade.php monitoring (3 peran)
resources/views/partials/bmc-result.blade.php           hasil poin BMC (5 peran)
resources/views/partials/ckeditor.blade.php             editor, hanya bila dibutuhkan
```

### Logika bersama

```
app/Services/ProductDetailService.php     query detail produk
app/Services/MonitoringStatsService.php   statistik monitoring bulanan/tahunan
app/Services/ProductAssetUploader.php     unggah gambar produk yang tervalidasi
app/Support/LegacyPassword.php            verifikasi hash lama + upgrade ke bcrypt
app/Support/Embed.php                     penyaringan tautan video/URL
```

### Password

Akun siswa lama memakai `md5($p) . sha1($p)` dan mentor lama memakai `md5($p)`.
Keduanya masih diterima saat login, lalu **otomatis ditulis ulang sebagai bcrypt**
pada login berhasil pertama. Akun baru selalu bcrypt.

## Catatan pemeliharaan

- Menu sidebar diubah lewat `config/navigation.php`, bukan dengan menyunting Blade.
- Warna, jarak dan radius berasal dari custom property di `public/css/bisa.css`;
  ubah token di `:root` daripada menambah `<style>` per halaman.
- Status laporan bulanan adalah enum `pending` / `disetujui` / `ditolak` — pakai
  konstanta `MonthlyReport::STATUS_*`, jangan string literal berkapital.
- Tautan video dari pengguna tidak pernah dirender sebagai HTML; lewatkan melalui
  `App\Support\Embed`.
- Telescope hanya terpasang di `require-dev` dan hanya didaftarkan pada
  environment `local`/`testing` (lihat `AppServiceProvider::register`).
- Sebelum rilis: `APP_ENV=production`, `APP_DEBUG=false`.

## Hal yang masih terbuka

- **Laravel 9 sudah habis masa dukungannya.** `composer audit` melaporkan
  advisory pada beberapa paket. Upgrade ke rilis yang didukung sebaiknya
  dijadwalkan tersendiri.
- Riwayat git masih memuat dump basis data lama berisi nama, NIS, tanggal lahir
  dan hash password mahasiswa asli. Berkasnya sudah dihapus dari working tree,
  tetapi menghapusnya dari riwayat memerlukan penulisan ulang riwayat repositori.
