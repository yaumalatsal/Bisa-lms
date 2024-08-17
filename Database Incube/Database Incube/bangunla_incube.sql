-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 31, 2023 at 03:20 PM
-- Server version: 10.3.39-MariaDB-cll-lve
-- PHP Version: 8.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bangunla_incube`
--

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_step` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `id_mentor` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `komentar` varchar(255) NOT NULL,
  `status` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `id_step`, `id_produk`, `id_mentor`, `judul`, `komentar`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 1, 1, 'Logonya Kurang Menarik', 'Busyet dahhhh jelek bener logo lu', 1, '2022-09-28 07:14:56', '2022-09-29 00:37:28'),
(2, 3, 3, 1, 'Value Propostion Kurang', 'Value proposition kurang lengkap bosss......', 1, '2022-09-29 02:44:26', '2022-09-29 02:47:08'),
(3, 3, 3, 1, 'Customer Segment Kurang mantap', 'Perbaiki lagi', 1, '2022-09-29 02:46:10', '2022-09-29 02:46:41'),
(4, 1, 4, 1, 'Revisi Business Model', 'Kurang lengkap', 1, '2022-09-29 02:47:22', '2022-09-29 02:47:37'),
(5, 4, 4, 1, 'Logo harap diganti', 'Maaf itu logonya kok makanan yaa', 1, '2022-09-29 03:00:21', '2022-09-29 03:02:18'),
(6, 1, 5, 1, 'Abtrak mu kurang', 'Bla bla blaaaaa', 0, '2022-10-06 05:59:21', '2022-10-06 05:59:21'),
(7, 3, 1, 1, 'bmc kosong', 'maaf bmcmu masih kosong', 0, '2022-10-06 10:32:12', '2022-10-06 10:32:12'),
(8, 3, 2, 1, 'Kulit Semangka Enak', 'Value proporsition kurang lengkap', 1, '2022-10-19 03:54:32', '2022-10-19 03:55:05'),
(9, 5, 2, 1, 'Kulit Semangka Enak', 'Publikasi produk kurang bagus', 1, '2022-10-19 04:30:50', '2022-10-19 04:31:13'),
(10, 3, 4, 1, 'Value Proposition Dijelaskan', 'Dijelaskan lebih detail apa maksudnya 10/10 itu', 1, '2022-10-24 03:00:31', '2022-10-24 03:04:29');

-- --------------------------------------------------------

--
-- Table structure for table `jawaban_bmc`
--

CREATE TABLE `jawaban_bmc` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_pertanyaan` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `jawaban` varchar(255) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jawaban_bmc`
--

INSERT INTO `jawaban_bmc` (`id`, `id_pertanyaan`, `id_produk`, `jawaban`, `id_siswa`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'Khasiat yang sangat banyak', 4, '2022-10-19 03:51:46', '2022-10-19 03:51:46'),
(2, 2, 2, 'Mengurangi limbah kulit semangka', 4, '2022-10-19 03:52:16', '2022-10-19 03:52:16'),
(3, 1, 9, 'menghadirkan solusi dengan berbagai layanan yang mencakup pengelolaan penjualan', 9, '2022-10-24 02:45:17', '2022-10-24 02:45:17'),
(4, 2, 9, 'membantu mengelola toko seperti pengelolaan stok dan pembayaran', 9, '2022-10-24 02:46:34', '2022-10-24 02:46:34'),
(5, 3, 9, 'untuk para pengusaha yang memiliki toko atau kedai', 9, '2022-10-24 02:47:16', '2022-10-24 02:47:16'),
(6, 1, 6, 'melayanani pembuatan web tanpa coding sendiri', 31, '2022-10-24 02:54:52', '2022-10-24 02:56:51'),
(7, 1, 4, '10/10', 47, '2022-10-24 02:55:19', '2022-10-24 02:55:19'),
(8, 1, 5, 'Memudahkan konsumen dalam membeli sembako', 33, '2022-10-24 02:55:52', '2022-10-24 02:55:52'),
(9, 2, 5, 'Kesulitan dalam mencari sembako', 33, '2022-10-24 02:56:39', '2022-10-24 02:56:39'),
(10, 2, 4, 'Semua masalah yang ada di aplikasi kita akan kita bantu selesaikan\'', 47, '2022-10-24 02:56:46', '2022-10-24 02:56:46'),
(11, 2, 13, 'Mempermudah para konsumen untuk membayar kartu tol', 45, '2022-10-24 02:56:53', '2022-10-24 02:56:53'),
(12, 1, 7, 'pemberian beberapa fitur gratis tanpa berbayar dalam pembuatan game', 34, '2022-10-24 02:57:16', '2022-10-24 02:57:16'),
(13, 1, 3, '-Memberi tau rekomendasi toko yang sedang ramai dan memberi diskon \r\n-Memberi tau toko yang memiliki kualtias yang bagus melalui rating yang telah disediakan', 32, '2022-10-24 02:57:19', '2022-10-24 02:57:19'),
(14, 3, 5, 'Kepada masyarakat yang membutuhkan sembako', 33, '2022-10-24 02:57:39', '2022-10-24 02:57:39'),
(15, 1, 13, 'Pemberian jasa tiket tol', 45, '2022-10-24 02:57:42', '2022-10-24 02:59:11'),
(16, 2, 6, 'client yang tidak bisa membuat web sendiri', 31, '2022-10-24 02:57:50', '2022-10-24 02:57:50'),
(17, 3, 4, 'Untuk pelanggan dan kita sendiri', 47, '2022-10-24 02:57:54', '2022-10-24 02:57:54'),
(18, 1, 10, 'Dapat 1 tiket gratis apabila membeli tiket sebanyak 20 tiket', 35, '2022-10-24 02:58:13', '2022-10-24 02:58:13'),
(19, 2, 3, '-Mempermudah pelanggan untuk mencari barang yang dibutuhkan', 32, '2022-10-24 02:58:19', '2022-10-24 02:58:19'),
(20, 1, 11, 'Aplikasi Membaca dan Membuat novel Online', 30, '2022-10-24 02:58:22', '2022-10-24 02:58:22'),
(21, 1, 8, 'Memberikan jasa untuk menyediakan barang yang dijual di pasar tradisional dan akan langsung diantar oleh jasa antar yang sudah disediakan.', 51, '2022-10-24 02:58:27', '2022-10-24 02:58:27'),
(22, 3, 6, 'untuk orang yang tidak bisa membuat web', 31, '2022-10-24 02:58:57', '2022-10-24 02:58:57'),
(23, 2, 10, 'Mempermudah orang untuk membeli tiket yang harus antri panjang', 35, '2022-10-24 02:59:13', '2022-10-24 02:59:13'),
(24, 2, 8, 'Mempermudah pembeli untuk mendapatkan barang yang diinginkan dari pasar tradisional tanpa harus pergi ke lokasi secara langsung.', 51, '2022-10-24 02:59:29', '2022-10-24 02:59:29'),
(25, 3, 3, '-Untuk kalangan remaja dan dewasa', 32, '2022-10-24 02:59:36', '2022-10-24 02:59:36'),
(26, 2, 7, 'membantu seseorang yang ingin membuat game terutama yang masih awam dalam cara pembuatan game', 34, '2022-10-24 02:59:37', '2022-10-24 02:59:37'),
(27, 2, 12, 'mempersingkat jarak antara user dengan pelanggan serta memudahkan konsumen untuk memilih dan menyewa vendor dan hal-hal lainnya.', 50, '2022-10-24 02:59:40', '2022-10-24 02:59:40'),
(28, 1, 14, 'memberikan penilaian terhadap bisnis, baik dari sisi pelayanan kami ataupun kualitas apa yang kami kerjakan, dan kemudahan mereka untuk mendapatkan hasil yang maksimal dari apa yang mereka percayakan terhadap jasa kami', 62, '2022-10-24 03:00:07', '2022-10-24 03:00:07'),
(29, 3, 10, 'Untuk orang-orang yang ingin menonton bioskop', 35, '2022-10-24 03:00:48', '2022-10-24 03:00:48'),
(30, 3, 13, 'Untuk masyarakat yang ingin melewati jalan tol', 45, '2022-10-24 03:00:56', '2022-10-24 03:00:56'),
(31, 3, 7, 'untuk para pemula yang ingin membuat game', 34, '2022-10-24 03:01:00', '2022-10-24 03:01:00'),
(32, 1, 12, 'banyaknya varian yang dapat disewa memudahkan pelanggan untuk dapat menyewa seperti yang diinginkan', 50, '2022-10-24 03:01:03', '2022-10-24 03:01:03'),
(33, 3, 8, 'Untuk orang yang ingin membeli barang di pasar tradisional tanpa kesusahan.', 51, '2022-10-24 03:01:38', '2022-10-24 03:01:38'),
(34, 3, 12, 'untuk para konsumen yang ingin melakukan pernikahan', 50, '2022-10-24 03:02:00', '2022-10-24 03:02:00'),
(35, 2, 11, 'Membantu Pelanggan Mencari Judul Buku dan Genre Yang Sesuai dengan Pelanggan', 30, '2022-10-24 03:02:18', '2022-10-24 03:02:18'),
(36, 2, 14, 'masalah yg akan kami selesaikan disuatu jasa kami ialah seperti, sepatu atau sendal yg kotor dan tidak sempat untuk membersihkan dalam waktu singkat', 62, '2022-10-24 03:03:41', '2022-10-24 03:03:41'),
(37, 3, 11, 'Untuk Pelanggan Dan Pecinta Novel', 30, '2022-10-24 03:05:07', '2022-10-24 03:05:07'),
(38, 3, 14, 'ya untuk para pelanggan', 62, '2022-10-24 03:06:08', '2022-10-24 03:06:08');

-- --------------------------------------------------------

--
-- Table structure for table `logo_produk`
--

CREATE TABLE `logo_produk` (
  `id` int(10) UNSIGNED NOT NULL,
  `logo_produk` varchar(255) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `deskripsi` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `logo_produk`
--

INSERT INTO `logo_produk` (`id`, `logo_produk`, `id_produk`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, '24_10_2022_03_24_32_6.png', 6, 'nama logo web', '2022-10-24 03:24:32', '2022-10-24 03:24:32'),
(2, '24_10_2022_03_27_07_9.jpg', 9, 'terdapat logo warung dan note atau catatan', '2022-10-24 03:27:07', '2022-10-24 03:27:07'),
(3, '24_10_2022_03_28_59_11.png', 11, 'Kerenn', '2022-10-24 03:28:59', '2022-10-24 03:28:59'),
(4, '24_10_2022_03_30_59_4.jpg', 4, 'Makna dari warna logo tersebut adalah, melambangkan warna video pada zaman awal mula video pertama, dan gambar logo tersebut terinspirasi dari proyektor pertama yang ada.', '2022-10-24 03:30:59', '2022-10-24 03:30:59'),
(5, '24_10_2022_03_34_00_3.png', 3, 'logo GO-DOl bermakna blablabla', '2022-10-24 03:34:00', '2022-10-24 03:34:00'),
(6, '24_10_2022_03_34_06_8.png', 8, 'Logo Pasline ini bermakna menyediakan barang di pasar tradisional', '2022-10-24 03:34:06', '2022-10-24 03:34:06'),
(7, '24_10_2022_03_35_19_5.png', 5, 'Logo TokoRuko', '2022-10-24 03:35:19', '2022-10-24 03:35:19'),
(8, '24_10_2022_03_35_25_12.png', 12, 'logo W-shoot', '2022-10-24 03:35:25', '2022-10-24 03:35:25'),
(9, '24_10_2022_03_54_08_13.png', 13, 'Agar my-tol selalu bersinar', '2022-10-24 03:38:51', '2022-10-24 03:54:08'),
(10, '24_10_2022_03_47_10_7.png', 7, 'pembuatan game awal', '2022-10-24 03:47:10', '2022-10-24 03:47:10'),
(11, '24_10_2022_03_50_00_14.png', 14, 'sebuah pelayanan cuci berbagai macam alas kaki seperti sepatu ataupun semacamnya', '2022-10-24 03:50:00', '2022-10-24 03:50:00');

-- --------------------------------------------------------

--
-- Table structure for table `master_bmc`
--

CREATE TABLE `master_bmc` (
  `id` int(10) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `route` varchar(50) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `video` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_bmc`
--

INSERT INTO `master_bmc` (`id`, `judul`, `deskripsi`, `route`, `icon`, `video`, `created_at`, `updated_at`) VALUES
(1, 'Value Proposition (Proposisi Nilai)', 'Proposisi Nilai adalah dasar untuk bisnis/produk apa pun. Ini adalah konsep dasar pertukaran nilai antara bisnis Anda dan pelanggan/klien Anda.Umumnya, nilai ditukar dari pelanggan dengan uang ketika masalah diselesaikan atau rasa sakit dihilangkan oleh b', '/vp', 'alur1.png', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/ucXhGmdcwLo\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', '2022-09-14 07:36:08', '2022-11-19 13:01:41'),
(2, 'Customer Segments (Segmentasi Pelanggan)', 'Segmentasi Pelanggan adalah praktik membagi basis pelanggan menjadi kelompok-kelompok individu yang serupa dalam cara tertentu, seperti usia, jenis kelamin, minat, dan kebiasaan belanja.', '/cs', 'alur2.png', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/PcPrW3ru2bo\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', '2022-09-14 07:38:48', '2022-11-19 13:01:52'),
(3, 'Customer Relationships ( Hubungan Pelanggan)', 'Hubungan dengan customer', '/cr', 'bmc3.png', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/FWN96zCeHbg\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', '2022-11-19 12:27:13', '2022-11-19 13:02:00'),
(4, 'Channels ( Penyaluran )', 'Mitra Dengan Pebisnis Lain', '/cn', 'bmc4.png', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/FWN96zCeHbg\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', '2022-11-19 12:27:13', '2022-11-19 13:03:46'),
(5, 'Key Activities (Akitivitas Utama)', 'tindakan yang dilakukan bisnis Anda untuk mencapai proposisi nilai bagi pelanggan Anda.', '/ka', 'bmc5.png', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/FWN96zCeHbg\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', '2022-11-19 12:27:13', '2022-11-19 13:03:31'),
(6, 'Key Resources (Sumber Daya Utama)', 'Selanjutnya, Anda harus memikirkan tentang sumber daya praktis apa yang diperlukan untuk mencapai aktivitas (tindakan) utama bisnis.', '/kr', 'bmc6.png', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/FWN96zCeHbg\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', '2022-11-19 12:27:13', '2022-11-19 13:03:41'),
(7, 'Key Partners ( Mitra )', 'daftar perusahaan/pemasok/pihak eksternal lain yang mungkin Anda perlukan untuk mencapai aktivitas utama Anda dan memberikan nilai kepada pelanggan.', '/kp', 'bmc7.png', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/FWN96zCeHbg\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', '2022-11-19 12:27:13', '2022-11-19 13:03:51'),
(8, 'Cost Structures (Biaya Operasional)', 'Struktur biaya bisnis Anda didefinisikan sebagai biaya moneter operasi sebagai bisnis.', '/cs', 'bmc8.png', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/FWN96zCeHbg\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', '2022-11-19 12:27:13', '2022-11-19 13:04:29'),
(9, 'Revenue Streams (Keuntungan)', 'cara bisnis Anda mengubah Proposisi Nilai atau solusi Anda untuk masalah pelanggan menjadi keuntungan finansial.', '/rs', 'bmc9.png', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/FWN96zCeHbg\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', '2022-11-19 12:27:13', '2022-11-19 13:04:54');

-- --------------------------------------------------------

--
-- Table structure for table `master_step`
--

CREATE TABLE `master_step` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama_step` varchar(255) NOT NULL,
  `deskripsi` varchar(100) NOT NULL,
  `route` varchar(255) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `step_number` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_step`
--

INSERT INTO `master_step` (`id`, `nama_step`, `deskripsi`, `route`, `gambar`, `step_number`, `created_at`, `updated_at`) VALUES
(1, 'Abstrak  Produk', 'Definisikasn secara singkat produkmu', '/product_abstract', 'alur1.png', 1, '2022-09-14 07:23:57', '2022-09-14 07:26:17'),
(2, 'Pembentukan Tim ', 'Buat tim hebatmu', '/tahap_team', 'alur2.png', 2, '2022-09-14 07:23:57', '2022-09-14 07:26:23'),
(3, 'Model Bisnis', 'Mengkonsep Model Bisnis Menggunakan Business Model Canvas', '/bmc', 'alur3.png', 3, '2022-09-14 07:26:55', '2022-09-29 04:10:06'),
(4, 'Logo dan Prototype', 'Membuat prototype dan logo  produk', '/proto', 'alur4.png', 4, '2022-09-15 07:12:37', '2022-09-29 04:13:38'),
(5, 'Publikasi Produk', 'Tahap untuk membuat luaran publikasi produk', '/publikasi', 'alur4.png', 5, '2022-09-15 07:36:16', '2022-09-29 04:11:45'),
(6, 'Presentasi Produk', 'Tahap pembuatan file presentasi produk', '/presentasi', 'alur4.png', 6, '2022-09-26 02:34:51', '2022-09-29 04:12:31');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_produk` int(11) NOT NULL DEFAULT 0,
  `id_siswa` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id`, `id_produk`, `id_siswa`, `position`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 1, '2022-10-18 06:58:40', '2022-10-18 06:58:40'),
(5, 1, 1, 2, '2022-10-18 07:09:15', '2022-10-18 07:09:15'),
(6, 2, 4, 1, '2022-10-19 03:43:51', '2022-10-19 03:43:51'),
(7, 2, 5, 2, '2022-10-19 03:48:11', '2022-10-19 03:48:11'),
(8, 2, 6, 3, '2022-10-19 03:48:52', '2022-10-19 03:48:52'),
(9, 3, 32, 1, '2022-10-24 02:02:35', '2022-10-24 02:02:35'),
(10, 4, 47, 1, '2022-10-24 02:02:48', '2022-10-24 02:02:48'),
(11, 5, 33, 1, '2022-10-24 02:03:03', '2022-10-24 02:03:03'),
(12, 6, 31, 1, '2022-10-24 02:03:28', '2022-10-24 02:03:28'),
(13, 7, 34, 1, '2022-10-24 02:03:32', '2022-10-24 02:03:32'),
(14, 8, 51, 1, '2022-10-24 02:03:57', '2022-10-24 02:03:57'),
(15, 9, 9, 1, '2022-10-24 02:04:41', '2022-10-24 02:04:41'),
(16, 10, 35, 1, '2022-10-24 02:04:50', '2022-10-24 02:04:50'),
(17, 11, 30, 1, '2022-10-24 02:05:07', '2022-10-24 02:05:07'),
(18, 12, 50, 1, '2022-10-24 02:05:25', '2022-10-24 02:05:25'),
(19, 13, 45, 1, '2022-10-24 02:05:47', '2022-10-24 02:05:47'),
(20, 14, 62, 1, '2022-10-24 02:08:47', '2022-10-24 02:08:47'),
(21, 9, 16, 2, '2022-10-24 02:11:30', '2022-10-24 02:11:30'),
(22, 9, 28, 3, '2022-10-24 02:12:13', '2022-10-24 02:12:13'),
(23, 11, 38, 3, '2022-10-24 02:13:48', '2022-10-24 02:13:48'),
(25, 8, 43, 2, '2022-10-24 02:13:57', '2022-10-24 02:13:57'),
(26, 5, 29, 3, '2022-10-24 02:13:58', '2022-10-24 02:13:58'),
(27, 6, 41, 2, '2022-10-24 02:14:03', '2022-10-24 02:14:03'),
(28, 4, 40, 3, '2022-10-24 02:14:16', '2022-10-24 02:14:16'),
(29, 11, 48, 2, '2022-10-24 02:14:18', '2022-10-24 02:14:18'),
(30, 6, 55, 3, '2022-10-24 02:14:22', '2022-10-24 02:14:22'),
(31, 5, 42, 2, '2022-10-24 02:14:29', '2022-10-24 02:14:29'),
(32, 8, 56, 3, '2022-10-24 02:14:29', '2022-10-24 02:14:29'),
(33, 10, 46, 2, '2022-10-24 02:14:32', '2022-10-24 02:14:32'),
(34, 7, 53, 2, '2022-10-24 02:14:32', '2022-10-24 02:14:32'),
(35, 13, 52, 2, '2022-10-24 02:14:37', '2022-10-24 02:14:37'),
(36, 4, 36, 2, '2022-10-24 02:14:43', '2022-10-24 02:14:43'),
(37, 10, 54, 3, '2022-10-24 02:15:03', '2022-10-24 02:15:03'),
(38, 13, 37, 3, '2022-10-24 02:15:07', '2022-10-24 02:15:07'),
(39, 3, 49, 3, '2022-10-24 02:15:10', '2022-10-24 02:15:10'),
(40, 12, 58, 2, '2022-10-24 02:15:14', '2022-10-24 02:15:14'),
(41, 7, 44, 3, '2022-10-24 02:15:22', '2022-10-24 02:15:22'),
(42, 12, 59, 3, '2022-10-24 02:15:36', '2022-10-24 02:15:36'),
(43, 3, 39, 2, '2022-10-24 02:15:46', '2022-10-24 02:15:46'),
(44, 14, 57, 2, '2022-10-24 02:16:15', '2022-10-24 02:16:15'),
(45, 14, 63, 3, '2022-10-24 02:16:51', '2022-10-24 02:16:51'),
(46, 1, 2, 3, '2022-11-08 07:58:22', '2022-11-08 07:58:22'),
(47, 15, 64, 1, '2023-04-11 02:02:02', '2023-04-11 02:02:02');

-- --------------------------------------------------------

--
-- Table structure for table `mentor`
--

CREATE TABLE `mentor` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nomor_telepon` varchar(50) NOT NULL,
  `umur` int(11) NOT NULL,
  `instansi` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mentor`
--

INSERT INTO `mentor` (`id`, `nama`, `email`, `password`, `nomor_telepon`, `umur`, `instansi`, `created_at`, `updated_at`) VALUES
(1, 'Alpha Mentor', 'alphasmk@gmail.com', '202cb962ac59075b964b07152d234b70', '085790327100', 40, 'SMKN 1 PURWOSARI', '2022-08-31 03:51:37', '2022-10-18 06:56:01'),
(2, 'Beta Mentor', 'betasmk@gmail.com', '202cb962ac59075b964b07152d234b70', '085790327200', 48, 'SMKN 1 WONOREJO', '2022-08-31 03:52:10', '2022-10-18 06:56:15');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(12, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(13, '2022_08_29_052611_create_siswa_table', 1),
(14, '2022_08_29_060052_create_product_table', 1),
(15, '2022_08_29_065122_create_team_table', 1),
(16, '2022_08_31_025903_create_member_table', 1),
(17, '2022_08_31_034332_create_mentor_table', 2),
(18, '2022_08_31_042455_create_position_table', 3),
(26, '2022_09_01_064408_create_master_step_table', 4),
(27, '2022_09_01_064446_create_track_step_table', 4),
(28, '2022_09_10_004231_crete_master_bmc_table', 5),
(29, '2022_09_14_061217_create_pertanyaan_bmc_table', 5),
(30, '2022_09_14_062252_create_jawaban_bmc_table', 5),
(31, '2022_09_15_083509_create_protolink_table', 6),
(32, '2022_09_15_083756_create_logo_table', 6),
(33, '2022_09_22_133623_create_table_video_produk', 7),
(34, '2022_09_22_134924_create_table_poster_produk', 7),
(35, '2022_09_22_135311_create_table_poster_produk', 8),
(36, '2022_09_26_040745_create_table_presentasi', 9),
(37, '2022_09_27_044916_create_penilian', 10),
(38, '2022_09_27_051758_feedback', 10);

-- --------------------------------------------------------

--
-- Table structure for table `penilaian`
--

CREATE TABLE `penilaian` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_step` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `id_mentor` int(11) NOT NULL,
  `file_nilai` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penilaian`
--

INSERT INTO `penilaian` (`id`, `id_step`, `id_produk`, `id_mentor`, `file_nilai`, `created_at`, `updated_at`) VALUES
(1, 3, 2, 1, 'https://web.whatsapp.com/', '2022-10-19 03:58:38', '2022-10-19 03:58:38');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pertanyaan_bmc`
--

CREATE TABLE `pertanyaan_bmc` (
  `id` int(10) UNSIGNED NOT NULL,
  `pertanyaan` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `id_poin_bmc` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pertanyaan_bmc`
--

INSERT INTO `pertanyaan_bmc` (`id`, `pertanyaan`, `keterangan`, `id_poin_bmc`, `created_at`, `updated_at`) VALUES
(1, 'Apa nilai yang Anda berikan kepada pelanggan Anda?', 'Pemberian jasa susu gratis tapi tanpa kopi', '1', '2022-09-14 09:15:16', '2022-09-14 09:15:16'),
(2, 'Masalah pelanggan mana yang Anda bantu selesaikan?', 'mempersingkat jarak antara user dengan pelanggan', '1', '2022-09-14 09:16:04', '2022-09-14 09:16:04'),
(3, 'Untuk siapa kita memecahkan masalah?', 'Untuk siswa kelas 12 SMK', '2', '2022-09-14 10:20:11', '2022-09-14 10:20:11');

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `id` int(10) UNSIGNED NOT NULL,
  `posisi` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`id`, `posisi`, `created_at`, `updated_at`) VALUES
(1, 'Hustler', '2022-08-31 04:28:47', '2022-08-31 04:28:47'),
(2, 'Hipster', '2022-08-31 04:28:57', '2022-08-31 04:28:57'),
(3, 'Hacker', '2022-08-31 04:29:08', '2022-08-31 04:29:08');

-- --------------------------------------------------------

--
-- Table structure for table `poster_produk`
--

CREATE TABLE `poster_produk` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_produk` int(11) NOT NULL,
  `poster_produk` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `presentasi`
--

CREATE TABLE `presentasi` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_produk` int(11) NOT NULL,
  `deck` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `presentasi`
--

INSERT INTO `presentasi` (`id`, `id_produk`, `deck`, `created_at`, `updated_at`) VALUES
(1, 2, 'file:///D:/MAGANG/DOKUMENTASI/Bukpan%20INCUBE.pdf', '2022-10-19 04:37:41', '2022-10-19 04:37:41');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `id_mentor` int(11) NOT NULL,
  `id_ceo` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `nama_produk`, `deskripsi`, `id_mentor`, `id_ceo`, `created_at`, `updated_at`) VALUES
(1, 'Ternak NFT', 'Aplikasi edukasi NFT yang memudahkan generasi mudah dalam membangun asset digital', 1, 3, '2022-10-18 06:58:40', '2022-10-18 06:58:40'),
(2, 'Kulit Semangka Enak', 'Kripik yang terbuat dari kulit semangka yang kaya yang akan khasiat', 1, 4, '2022-10-19 03:43:51', '2022-10-19 03:43:51'),
(3, 'go-dol', 'menyediakan layanan rekomendasi toko dengan  barang yang anda butuhkan', 1, 32, '2022-10-24 02:02:35', '2022-10-24 02:02:35'),
(4, 'Editor Studio', 'Aplikasi ini melayani jasa mengedit Foto dan Video, kelebihan aplikasi ini anda tidak perlu mengedit sendiri, kualitas dijamin aman dan bagus.', 1, 47, '2022-10-24 02:02:48', '2022-10-24 02:02:48'),
(5, 'TokoRuko', 'Merupakan toko online yang menyediakan sembako.', 1, 33, '2022-10-24 02:03:03', '2022-10-24 02:03:03'),
(6, 'Webcahyo', 'penyedia jasa pembuatan web', 1, 31, '2022-10-24 02:03:28', '2022-10-24 02:03:28'),
(7, 'BeginnerGM', 'sebuah aplikasi untuk membantu pemula yang ingin membuat game', 1, 34, '2022-10-24 02:03:32', '2022-10-24 02:03:32'),
(8, 'Pasline', 'Aplikasi Pasline ini menyediakan berbagai barang dan bahan yang ada di pasar tradisional sekitar anda. Barang-barang yang sudah dibeli tersebut akan diantarkan oleh jasa antar khusus Pasline sendiri.', 1, 51, '2022-10-24 02:03:57', '2022-10-24 02:03:57'),
(9, 'S-NOTE', 'pengelolaan toko yang menghadirkan solusi dengan berbagai layanan yang mencakup pengelolaan penjualan, utang piutang, pengelolaan stok dan pembayaran yang akan terus dikembangan untuk memenuhi kebutuhan pengguna.', 1, 9, '2022-10-24 02:04:41', '2022-10-24 02:04:41'),
(10, 'TIXMAX', 'aplikasi TIXMAX adalah aplikasi yang mempermudah orang untuk membeli tiket nonton bioskop, diseluruh indonesia.', 1, 35, '2022-10-24 02:04:50', '2022-10-24 02:04:50'),
(11, 'Dig-Book', 'sebuah Aplikasi Buku Novel Yang Bisa Memberi Emoticon Disetiap Part Dan Bisa Mengarang Novel Sendiri  Serta Dilengkapi Backsound Musik', 1, 30, '2022-10-24 02:05:07', '2022-10-24 02:05:07'),
(12, 'w-shoot', 'aplikasi ini melayani pembelian dan penyewaan hal-hal yang berhubungan dengan weading, seperti jasa fotografer, penyewaan alat-alat weading pembelian undangan pernikahan dan hal-hal lain yang berhubungan dengan weading', 1, 50, '2022-10-24 02:05:25', '2022-10-24 02:05:25'),
(13, 'My-Tol', 'Membuat sebuah Aplikasi pembayaran tol yang bertujuan untuk mempermudah para konsumen', 1, 45, '2022-10-24 02:05:47', '2022-10-24 02:05:47'),
(14, 'WashNClean', 'Aplikasi jasa cuci sepatu online', 1, 62, '2022-10-24 02:08:47', '2022-10-24 02:08:47'),
(15, 'aplikasi jual beli sapi', 'aplikasi ini untuk jual beli sapi', 1, 64, '2023-04-11 02:02:02', '2023-04-11 02:02:02');

-- --------------------------------------------------------

--
-- Table structure for table `protolink`
--

CREATE TABLE `protolink` (
  `id` int(10) UNSIGNED NOT NULL,
  `link_figma` varchar(255) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `protolink`
--

INSERT INTO `protolink` (`id`, `link_figma`, `id_produk`, `created_at`, `updated_at`) VALUES
(1, 'https://www.figma.com/file/wvTTMa4HKmai4XZibDfMK5/Figma-Basics?node-id=0%3A286', 6, '2022-10-24 03:25:56', '2022-10-24 03:25:56'),
(2, 'https://pin.it/4ru2bcD', 4, '2022-10-24 03:28:41', '2022-10-24 03:28:41'),
(3, 'https://www.ncbi.nlm.nih.gov/books/NBK482263/', 9, '2022-10-24 03:29:03', '2022-10-24 03:29:03'),
(4, 'https://www.figma.com/file/NVIkpSN7cApvj7Zpt2G9Kk/11.-Faiq-Razzan-Afifie\'s-team-library?node-id=0%3A1', 11, '2022-10-24 03:30:23', '2022-10-24 03:30:23'),
(5, 'https://www.logomaker.com/diy-logo-upsells?lid=915061158', 12, '2022-10-24 03:31:22', '2022-10-24 03:31:22'),
(6, 'https://www.figma.com/file/UiGRVjSJt1cGpGL95KfGXV/PORTFOLIO-DARK-%2F-LIGHT-THEME-(Community)', 5, '2022-10-24 03:31:57', '2022-10-24 03:31:57'),
(7, 'https://www.figma.com/file/u5fkhq00sVUArRkD0lx5Da/AzizAan\'s-team-library', 3, '2022-10-24 03:33:17', '2022-10-24 03:33:17'),
(8, 'https://www.figma.com/file/TQUxJOO1rEy29fcKailDc3/Untitled?node-id=0%3A1', 8, '2022-10-24 03:34:20', '2022-10-24 03:34:20'),
(9, 'https://www.logomaker.com/diy-logo-upsells?lid=915060773', 13, '2022-10-24 03:35:30', '2022-10-24 03:35:30'),
(10, 'https://youtu.be/YdR7T9hehGA', 14, '2022-10-24 03:36:00', '2022-10-24 03:36:00'),
(11, 'https://youtu.be/9h-z0AyG42k', 7, '2022-10-24 03:36:27', '2022-10-24 03:36:27');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id` int(10) UNSIGNED NOT NULL,
  `nomor_induk` varchar(20) NOT NULL,
  `password` varchar(225) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `nama` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id`, `nomor_induk`, `password`, `tanggal_lahir`, `nama`, `created_at`, `updated_at`) VALUES
(1, '180533631533', '202cb962ac59075b964b07152d234b7040bd001563085fc35165329ea1ff5c5ecbdbbeef', '2022-10-19', 'Adam Maulana Dzikri', '2022-10-06 06:27:55', '2022-10-06 06:27:55'),
(2, '180533631522', '202cb962ac59075b964b07152d234b7040bd001563085fc35165329ea1ff5c5ecbdbbeef', '2022-10-31', 'Nico Robin', '2022-10-06 06:28:04', '2022-10-18 06:55:14'),
(3, '180533631521', '202cb962ac59075b964b07152d234b7040bd001563085fc35165329ea1ff5c5ecbdbbeef', '2022-10-21', 'Paijo Iskandar', '2022-10-06 06:28:17', '2022-10-18 07:16:00'),
(4, '190533646814', '202cb962ac59075b964b07152d234b7040bd001563085fc35165329ea1ff5c5ecbdbbeef', '2001-01-16', 'Dwi Risma', '2022-10-19 03:39:31', '2022-10-19 03:39:31'),
(5, '190533646875', '202cb962ac59075b964b07152d234b7040bd001563085fc35165329ea1ff5c5ecbdbbeef', '2001-01-16', 'Elok Rosyidatul', '2022-10-19 03:40:04', '2022-10-19 03:40:04'),
(6, '190533646787', '202cb962ac59075b964b07152d234b7040bd001563085fc35165329ea1ff5c5ecbdbbeef', '2001-01-16', 'Angga', '2022-10-19 03:40:21', '2022-10-19 03:40:21'),
(7, '11245/144.065', '582c1b6bc8290a5bc93c59e27c6310c519a7f0018fda73ab7285c70c73058b5a958ba8ab', '2005-11-15', 'Wafa Jaya Husein', '2022-10-24 01:47:49', '2022-10-24 01:47:49'),
(8, '11231/130.065', 'bbe3875e464c744402bb8c9348a7eb930ec1d0e424b55c9178364a56e7360e2c16ea6b6d', '2005-10-25', 'muh rafi fauzan a', '2022-10-24 01:47:55', '2022-10-24 01:47:55'),
(9, '11227', 'defac44447b57f152d14f30cea7a73cbc4b93599b61b85b1f109064294c5bd7adf73ca66', '2006-07-06', 'MAULANA ZIDAN NABIL ALAMSYAH', '2022-10-24 01:48:00', '2022-10-24 01:48:00'),
(10, '180533631565', '202cb962ac59075b964b07152d234b7040bd001563085fc35165329ea1ff5c5ecbdbbeef', '2022-06-12', 'Ulfatus Sa\'diyah', '2022-10-24 01:48:10', '2022-10-24 01:48:10'),
(11, '11211/110.065', '175b64271aa796b10b4a926c00f0db3aefd36d9d696983baf351a0489d836e7c8eeb0926', '2006-08-14', 'Adhi Rifqi Bayu Ananta', '2022-10-24 01:48:21', '2022-10-24 01:48:21'),
(12, '11215/114.065', '497ab30641dcdfab99aa8305854e5527ecf7300b1dd371687263164623f98f965dae67ca', '2005-05-08', 'Ananda Harfiana', '2022-10-24 01:48:22', '2022-10-24 01:48:22'),
(13, '11219/118.065', 'a546b9dbfb5e057ea3cfa8780d9dcdaa00ee002b7cbc41933f94aa9e5e0cfe76b0678acd', '2006-04-18', 'Dita Eka Maulidiyah', '2022-10-24 01:48:25', '2022-10-24 01:48:25'),
(14, '11238/137.065', '101a6ec9f938885df0a44f20458d2eb48a2da05455775e8987cbfac5a0ca54f3f728e274', '2005-05-05', 'Purnama Zibran Maulana', '2022-10-24 01:48:25', '2022-10-24 01:48:25'),
(15, '11214/113.065', 'f4f068e71e0d87bf0ad51e6214ab84e9c8a50f632c3c4baf27fc05facb1883104e1d16ef', '2005-05-27', 'aloysia bernadeth a', '2022-10-24 01:48:31', '2022-10-24 01:48:31'),
(16, '11241', 'defac44447b57f152d14f30cea7a73cbc4b93599b61b85b1f109064294c5bd7adf73ca66', '2005-09-15', 'SILVIA PUSPITASARI', '2022-10-24 01:49:02', '2022-10-24 01:49:02'),
(17, '11213/112.065', '46c0c574c3c9545701ad3f992c7701b2fb9e643f44009f64b59cf358d04e33445dbbe9eb', '2006-05-01', 'Ahnaf Farhan Bima Arya', '2022-10-24 01:49:11', '2022-10-24 01:49:11'),
(18, '0059631860', '5e6baf8720bd85371297a4921982e1b203b890a6b6d3c5932e45d7fa9ef49788027c0b96', '2005-05-11', 'tegar bagus santoso', '2022-10-24 01:49:25', '2022-10-24 01:49:25'),
(19, '11218/117.065', 'a546b9dbfb5e057ea3cfa8780d9dcdaa00ee002b7cbc41933f94aa9e5e0cfe76b0678acd', '2005-11-22', 'Diniah Syafia Arifina', '2022-10-24 01:49:35', '2022-10-24 01:49:35'),
(20, '11229/128.065', 'dc8cba528dfa740ea4cd94f69d6787aa252f4b1ce6dbb75a68aa7eec978ec74a8969c1e2', '2006-01-26', 'Muhammad Alexander Zulkarnain', '2022-10-24 01:49:45', '2022-10-24 01:49:45'),
(21, '11222/121.065', 'ac6ac60aabc230011111c77cc22a7ef418575fa12eb68eeef194b0eba37fcf1ae4395344', '2006-06-20', 'Farel Farizi Purnomosasi', '2022-10-24 01:50:07', '2022-10-24 01:50:07'),
(22, '11235/134.065', '575b2bb8f4c67628c9e7b4093e05992e7e0ad4a1a28c9963fe55dbb8bf9e387838973d55', '2005-12-12', 'Nifatul Rokmah', '2022-10-24 01:50:12', '2022-10-24 01:50:12'),
(23, '11244/143.065', '27527712b072e72c35248f1c105b5534103536ca769dac0e5306efca049963b9c7bfd99d', '2006-01-15', 'tyfosa helga wijaya', '2022-10-24 01:50:23', '2022-10-24 01:50:23'),
(24, '11243/142.065', 'e10adc3949ba59abbe56e057f20f883e7c4a8d09ca3762af61e59520943dc26494f8941b', '2005-11-01', 'Tsaniyah Mukamillah', '2022-10-24 01:50:28', '2022-10-24 01:50:28'),
(25, '11237/136.065', 'a8bba5e6dfe987476116dd0978efe3f3a1eaed74175c2038f8892d76c59052bfa6e4236e', '2006-02-06', 'Nur Faiz Tri Endytha', '2022-10-24 01:50:47', '2022-10-24 01:50:47'),
(26, '11228/127.065', '39b30f9943dcb473ca2cbb088ce4a5f5f23a70c07edec9714d4ea26885aab5421ace9937', '2006-07-30', 'Muhammad Afif Shohibulloh', '2022-10-24 01:51:18', '2022-10-24 01:51:18'),
(27, '11225/124.065', '69d289781240667f69ee30d79d90bd0e51ec90ec2b470399742b04dd3bb34b0ce0189bd6', '2005-10-09', 'Lailatul Sufiya Ramadani', '2022-10-24 01:51:31', '2022-10-24 01:51:31'),
(28, '11233', 'defac44447b57f152d14f30cea7a73cbc4b93599b61b85b1f109064294c5bd7adf73ca66', '2005-06-24', 'NAILATUL KAROMAH', '2022-10-24 01:51:44', '2022-10-24 01:51:44'),
(29, '11240', '005d8129f2ff1f399815bdfcefe569ade37b9b253cd97574aca81ff78693ecb9bac576a8', '2005-11-11', 'R.Bg. Mochammad Prakoso Abimanyu', '2022-10-24 01:51:45', '2022-10-24 01:51:45'),
(30, '11238', '101a6ec9f938885df0a44f20458d2eb48a2da05455775e8987cbfac5a0ca54f3f728e274', '2005-05-05', 'Purnama Zibran Maulana', '2022-10-24 01:51:52', '2022-10-24 01:51:52'),
(31, '11243', 'c37bf859faf392800d739a41fe5af15119865795547116ae27f09115e72c74d2c517d0b2', '2005-11-01', 'Tsaniyah Mukamillah', '2022-10-24 01:51:54', '2022-10-24 01:51:54'),
(32, '11231', 'bbe3875e464c744402bb8c9348a7eb930ec1d0e424b55c9178364a56e7360e2c16ea6b6d', '2005-10-25', 'muh rafi fauzan a', '2022-10-24 01:52:08', '2022-10-24 01:52:08'),
(33, '11211', '35906a6480cb8ed9c70ee4b5dd54370883fbb759e5f6b6cb8617fb3908ab74a388b8fc5c', '2006-08-14', 'Adhi Rifqi Bayu Ananta', '2022-10-24 01:52:19', '2022-10-24 01:52:19'),
(34, '11214', '9312df5b082df641f90349e16998d74fb50db7b94a8f030407963b500e6bbeda8812672b', '2005-05-27', 'aloysia bernadeth a', '2022-10-24 01:52:22', '2022-10-24 01:52:22'),
(35, '11228', '4f79764d0b5a619137a5c0c02fb6bd08ccc52eead26e35f3473f57dcbce79c350b6d9c8e', '2006-07-30', 'Muhammad Afif Shohibulloh', '2022-10-24 01:52:29', '2022-10-24 01:52:29'),
(36, '11213', '46c0c574c3c9545701ad3f992c7701b2fb9e643f44009f64b59cf358d04e33445dbbe9eb', '2006-05-01', 'Ahnaf Farhan Bima Arya', '2022-10-24 01:52:35', '2022-10-24 01:52:35'),
(37, '11232', '7aa6c8b10e20d9c3d0871e203fd37ca8cd810a887f0e0127371a874439dfec8e4142b2f1', '2005-10-31', 'Muhammad Ramadani', '2022-10-24 01:52:39', '2022-10-24 01:52:39'),
(38, '11220', '4d7565a0d64b31b41e9c0f04c59623b11b45e486e67020de9ef76b09363ebb1465ef48ce', '2006-08-26', 'Faiq Razzan Afifie', '2022-10-24 01:52:52', '2022-10-24 01:52:52'),
(39, '11244', '27527712b072e72c35248f1c105b5534103536ca769dac0e5306efca049963b9c7bfd99d', '2006-01-15', 'tyfosa helga wijaya', '2022-10-24 01:52:58', '2022-10-24 01:52:58'),
(40, '11225', '69d289781240667f69ee30d79d90bd0e51ec90ec2b470399742b04dd3bb34b0ce0189bd6', '2005-10-09', 'Lailatul Sufiya Ramadani', '2022-10-24 01:53:08', '2022-10-24 01:53:08'),
(41, '11239', 'c37bf859faf392800d739a41fe5af15119865795547116ae27f09115e72c74d2c517d0b2', '2005-08-31', 'Putri Nyskia Agustin Hirnanda', '2022-10-24 01:53:10', '2022-10-24 01:53:10'),
(42, '11235', '575b2bb8f4c67628c9e7b4093e05992e7e0ad4a1a28c9963fe55dbb8bf9e387838973d55', '2005-12-12', 'Nifatul Rokmah', '2022-10-24 01:53:25', '2022-10-24 01:53:25'),
(43, '11236', 'e9a4c2cfe47b7a4e5c51279f7872b1869a3e268d61e713af25fda4f3a7ba49d86e1d1760', '2006-08-31', 'Nur Achmad Alfianto', '2022-10-24 01:53:33', '2022-10-24 01:53:33'),
(44, '11229', 'dc8cba528dfa740ea4cd94f69d6787aa252f4b1ce6dbb75a68aa7eec978ec74a8969c1e2', '2006-01-26', 'Muhammad Alexander Zulkarnain', '2022-10-24 01:53:35', '2022-10-24 01:53:35'),
(45, '11219', '7aa6c8b10e20d9c3d0871e203fd37ca8cd810a887f0e0127371a874439dfec8e4142b2f1', '2006-04-18', 'Dita Eka Maulidiyah', '2022-10-24 01:53:44', '2022-10-24 01:53:44'),
(46, '11221', '4694cd2e2a3e83adf458237c2eae695a7632d24d9269106f44c5b7b7848a1095bbf7d4f6', '2006-06-29', 'Faizah Daaren', '2022-10-24 01:53:47', '2022-10-24 01:53:47'),
(47, '11245', '582c1b6bc8290a5bc93c59e27c6310c519a7f0018fda73ab7285c70c73058b5a958ba8ab', '2005-11-15', 'Wafa Jaya Husein', '2022-10-24 01:53:50', '2022-10-24 01:53:50'),
(48, '11224', 'e95f95f8ef998f9a6d6c5faca9236e4c15e60f2c3a2797c13f7809b50f46bbf2455cf318', '2005-07-24', 'Jihan Prahasti Saharani', '2022-10-24 01:53:57', '2022-10-24 01:53:57'),
(49, '11210', '442f000f3572feaa1fcc2a7e4e7f95028b400dc5dd43b8c6479b710aae77361bd7eaaf88', '2006-05-30', 'abdillah aziz putra susan', '2022-10-24 01:54:01', '2022-10-24 01:54:01'),
(50, '11212', '3ed6e995474bc6dddef7a6fc9b97c965c2c035fdf6170d48dc1f0d129776bf2ca17b1a72', '2006-09-04', 'afreza maulidiah', '2022-10-24 01:54:10', '2022-10-24 01:54:10'),
(51, '11215', '497ab30641dcdfab99aa8305854e5527ecf7300b1dd371687263164623f98f965dae67ca', '2005-05-08', 'Ananda Harfiana', '2022-10-24 01:54:13', '2022-10-24 01:54:13'),
(52, '11218', '7aa6c8b10e20d9c3d0871e203fd37ca8cd810a887f0e0127371a874439dfec8e4142b2f1', '2005-11-22', 'Diniah Syafia Arifina', '2022-10-24 01:54:18', '2022-10-24 01:54:18'),
(53, '11217', 'c9d2cce909ea37234be8af1a1f9588055ce6cf480683da4e2bcf0bcdf460ae03b57c4853', '2006-01-07', 'annisa mursalaat abdillah', '2022-10-24 01:54:26', '2022-10-24 01:54:26'),
(54, '11234', '100bef1a7a6e25c19f988ab151343ea9ada84a6500d19bdb161da4dd9aba1e03cf67c7b4', '2006-03-10', 'Nasywa Salsabilla', '2022-10-24 01:54:29', '2022-10-24 01:54:29'),
(55, '11230', 'c37bf859faf392800d739a41fe5af15119865795547116ae27f09115e72c74d2c517d0b2', '2005-12-15', 'muhammad Dwi Cahyo', '2022-10-24 01:54:45', '2022-10-24 01:54:45'),
(56, '11222', 'ac6ac60aabc230011111c77cc22a7ef418575fa12eb68eeef194b0eba37fcf1ae4395344', '2006-06-20', 'Farel Farizi Purnomosasi', '2022-10-24 01:54:53', '2022-10-24 01:54:53'),
(57, '11237', 'da4495175954b9cf6fb51993950b4ee7aa29ad5b3fbdc489bc8757d808aaab5d49d217e4', '2006-03-25', 'Nur Faiz Tri Endytha', '2022-10-24 01:55:01', '2022-10-24 01:55:01'),
(58, '11242', 'ba385a78c532bcea4a4ff4c103e2fd29d1312bfb6067c1d208fb71b89ab16e6efcb277ed', '2005-11-05', 'tegar bagus santoso', '2022-10-24 01:55:18', '2022-10-24 01:55:18'),
(59, '11226', '607e501266c684828a7d776342639a1ec1e81291726c4fab50e18f5390df12e5a46f15eb', '2005-01-08', 'M. ubaidilah', '2022-10-24 01:55:50', '2022-10-24 01:55:50'),
(60, '11216/115.065', 'cce359c6d787491b3795434294d858ee5e4e6d27982d9d0a74cf01cbe942962ade897bd5', '2006-02-07', 'Annisa Febrianti', '2022-10-24 01:56:44', '2022-10-24 01:56:44'),
(61, '11223/122.065', '3e73a017422e04ea6e890e001a8761018cf598a2cd9403ffc54a4a8b8ac0898e12cc5ec8', '2005-07-10', 'Indah Yulia', '2022-10-24 01:58:09', '2022-10-24 01:58:09'),
(62, '11216', 'cce359c6d787491b3795434294d858ee5e4e6d27982d9d0a74cf01cbe942962ade897bd5', '2006-02-07', 'Annisa Febrianti', '2022-10-24 02:05:27', '2022-10-24 02:05:27'),
(63, '11223', '3e73a017422e04ea6e890e001a8761018cf598a2cd9403ffc54a4a8b8ac0898e12cc5ec8', '2005-07-10', 'Indah Yulia Rahmawati', '2022-10-24 02:06:15', '2022-10-24 02:06:15'),
(64, '11200', '5d93ceb70e2bf5daa84ec3d0cd2c731adb25f2fc14cd2d2b1e7af307241f548fb03c312a', '2023-01-30', 'tes', '2023-04-11 01:59:40', '2023-04-11 01:59:40');

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `track_step`
--

CREATE TABLE `track_step` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_produk` int(11) NOT NULL,
  `id_ceo` int(11) NOT NULL,
  `id_step` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `track_step`
--

INSERT INTO `track_step` (`id`, `id_produk`, `id_ceo`, `id_step`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 3, 0, '2022-10-18 06:58:40', '2022-11-19 12:22:04'),
(2, 2, 4, 6, 0, '2022-10-19 03:43:51', '2022-10-19 04:47:06'),
(3, 3, 32, 4, 1, '2022-10-24 02:02:35', '2022-10-24 03:34:05'),
(4, 4, 47, 5, 0, '2022-10-24 02:02:48', '2022-10-24 03:31:38'),
(5, 5, 33, 4, 1, '2022-10-24 02:03:03', '2022-10-24 03:36:21'),
(6, 6, 31, 5, 0, '2022-10-24 02:03:28', '2022-10-24 03:27:23'),
(7, 7, 34, 4, 1, '2022-10-24 02:03:32', '2022-10-24 03:47:18'),
(8, 8, 51, 4, 1, '2022-10-24 02:03:58', '2022-10-24 03:34:37'),
(9, 9, 9, 4, 1, '2022-10-24 02:04:42', '2022-10-24 03:36:26'),
(10, 10, 35, 4, 1, '2022-10-24 02:04:50', '2022-10-24 03:40:11'),
(11, 11, 30, 5, 0, '2022-10-24 02:05:07', '2022-10-24 03:32:26'),
(12, 12, 50, 4, 1, '2022-10-24 02:05:25', '2022-10-24 03:36:25'),
(13, 13, 45, 4, 1, '2022-10-24 02:05:47', '2022-10-24 03:54:18'),
(14, 14, 62, 4, 1, '2022-10-24 02:08:47', '2022-10-24 03:50:12'),
(15, 15, 64, 1, 0, '2023-04-11 02:02:02', '2023-04-11 02:06:39');

-- --------------------------------------------------------

--
-- Table structure for table `video_produk`
--

CREATE TABLE `video_produk` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_produk` int(11) NOT NULL,
  `link_video` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jawaban_bmc`
--
ALTER TABLE `jawaban_bmc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logo_produk`
--
ALTER TABLE `logo_produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_bmc`
--
ALTER TABLE `master_bmc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_step`
--
ALTER TABLE `master_step`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mentor`
--
ALTER TABLE `mentor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penilaian`
--
ALTER TABLE `penilaian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `pertanyaan_bmc`
--
ALTER TABLE `pertanyaan_bmc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `poster_produk`
--
ALTER TABLE `poster_produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `presentasi`
--
ALTER TABLE `presentasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `protolink`
--
ALTER TABLE `protolink`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `track_step`
--
ALTER TABLE `track_step`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video_produk`
--
ALTER TABLE `video_produk`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `jawaban_bmc`
--
ALTER TABLE `jawaban_bmc`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `logo_produk`
--
ALTER TABLE `logo_produk`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `master_bmc`
--
ALTER TABLE `master_bmc`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `master_step`
--
ALTER TABLE `master_step`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `mentor`
--
ALTER TABLE `mentor`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `penilaian`
--
ALTER TABLE `penilaian`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pertanyaan_bmc`
--
ALTER TABLE `pertanyaan_bmc`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `poster_produk`
--
ALTER TABLE `poster_produk`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `presentasi`
--
ALTER TABLE `presentasi`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `protolink`
--
ALTER TABLE `protolink`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `track_step`
--
ALTER TABLE `track_step`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `video_produk`
--
ALTER TABLE `video_produk`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
