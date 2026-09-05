# BISa — Platform Inkubasi & Monitoring Bisnis Mahasiswa

Aplikasi Laravel 9 untuk mendampingi mahasiswa Universitas Negeri Malang menyusun
konsep bisnis, melaporkan perkembangan penjualan, dan mempertemukannya dengan
mentor serta investor.

## Peran

| Peran        | Masuk lewat        | Guard      | Ringkasan |
|--------------|--------------------|------------|-----------|
| **Siswa**    | `/login`           | `siswa`    | Membentuk tim, mengisi tahap inkubasi (abstrak → tim → BMC → prototype → publikasi → presentasi), mengirim laporan bulanan, mengikuti course dan kuis. |
| **Mentor**   | `/mentor/login`    | `mentor`   | Membimbing produk, memvalidasi tahapan, memberi feedback dan nilai, menyetujui laporan bulanan, mengelola course. |
| **Admin**    | `/admin/login`     | `admin`    | Mengelola produk, siswa, materi, soal kuis dan pertanyaan BMC. |
| **Investor** | `/investor/login`  | `investor` | Menelusuri produk pameran dan monitoring bisnisnya. |

Setiap area dilindungi middleware di sisi server (`auth.role:siswa`,
`auth.role:mentor`, `auth:admin`, `auth:investor`).

## Menjalankan secara lokal

```bash
composer install
cp .env.example .env
php artisan key:generate

# Sesuaikan DB_* di .env, lalu:
php artisan migrate
php artisan db:seed          # opsional

php artisan serve
```

Unggahan produk (logo, poster) ditulis langsung ke `public/logo_produk` dan
`public/poster_produk`; unggahan laporan memakai disk `public`, jadi jalankan
sekali:

```bash
php artisan storage:link
```

## Pengujian

Suite memakai MySQL. Buat database kosong bernama `bisa_test` (atau ubah
`DB_DATABASE` di `phpunit.xml`), lalu:

```bash
php vendor/bin/phpunit
```

Cakupan saat ini:

- `tests/Feature/SmokeTest.php` — meminta **setiap** rute GET sebagai peran
  pemiliknya dan memastikan tidak ada yang error. Ini jaring pengaman utama saat
  mengubah view atau controller.
- `tests/Feature/AuthenticationTest.php` — penjagaan area per peran, dan
  penerimaan password lama beserta peningkatannya ke bcrypt.
- `tests/Feature/AuthorizationTest.php` — batas antar-tim dan antar-mentor.
- `tests/Feature/MonitoringStatsTest.php` — perhitungan statistik monitoring.
- `tests/Unit/EmbedTest.php` — penyaringan tautan video.

## Struktur yang perlu diketahui

### Tampilan

Seluruh peran memakai **satu** kerangka halaman:

```
resources/views/layouts/app.blade.php        kerangka aplikasi (topbar + sidebar)
resources/views/layouts/guest.blade.php      kerangka halaman login/registrasi
resources/views/layouts/partials/            topbar, sidebar, flash message
config/navigation.php                        isi menu tiap peran
public/css/bisa.css                          design system (token, komponen, dark mode)
public/js/bisa.js                            perilaku bersama (tema, sidebar, DataTables)
```

Berkas `resources/views/{dashboard_template,admin,mentor,investor}/template/index.blade.php`
kini hanya shim tipis yang menyatakan peran mana yang sedang dirender, sehingga
view lama tetap bisa `@extends` ke path yang sama.

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
pada login berhasil pertama. Akun baru selalu bcrypt. Lihat
`app/Support/LegacyPassword.php`.

## Catatan pemeliharaan

- Menu sidebar diubah lewat `config/navigation.php`, bukan dengan menyunting Blade.
- Warna, jarak dan radius berasal dari custom property di `public/css/bisa.css`;
  ubah token di `:root` daripada menambah override per halaman.
- Status laporan bulanan adalah enum `pending` / `disetujui` / `ditolak` — pakai
  konstanta `MonthlyReport::STATUS_*`, jangan string literal berkapital.
