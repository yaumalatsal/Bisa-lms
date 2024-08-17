<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', [DashboardController::class,'index']);
// Route::get('/', 'DashboardController@index');
// routes/web.php
Route::get('/', [DashboardController::class, 'penilaian_siswa'])->name('dashboard.dashboard');

Route::get('/artikel/bmc', function () {
    return view('artikel.bmc');
});

// Route::get('/inkubasi', 'DashboardController@inkubasi');
Route::get('/inkubasi', [DashboardController::class, 'inkubasi'])->name('dashboard.inkubasi');
Route::get('/laporan', [DashboardController::class, 'laporan'])->name('dashboard.laporan');


// // Autentifikasi
Route::get('/register_mentor', 'DashboardController@register_mentor');
Route::get('/register_siswa', 'DashboardController@register_siswa');
Route::post('/pendaftaran_siswa', 'SiswaController@register_siswa');
Route::get('/logout_siswa', 'SiswaController@logout');
Route::post('/signin', 'SiswaController@login');
// Route::get('/dashboard', 'DashboardController@index');
Route::get('/login', 'DashboardController@login');

// feedback
Route::get('/feedback', 'FeedbackController@siswaFeedBack');
Route::post('/konfirmFeed', 'FeedbackController@konfirmFeed');


// penilaian
Route::get('/penilaian', 'PenilaianController@siswaPenilaian');

//monitoring
Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring.index');
Route::post('/monitoringstore', [MonitoringController::class, 'store'])->name('monitoring.store');

//ranking
Route::get('/ranking', [RankingController::class, 'index'])->name('ranking.index');
Route::post('/rankingstore', [RankingController::class, 'store'])->name('ranking.store');

// produk
Route::post('/register_produk', 'ProdukController@registerProduk');
Route::get('/produk', 'ProdukController@siswaProduk');
Route::get('/detail_result_bmc/{id_bmc}/{id_produk}', 'BmcController@resultSiswaBMC');


//tahap team and member
Route::post('/cari_member', 'SiswaController@searchByNis');
Route::post('/tambah_member','TeamController@tambah_member');
Route::get('/delete_member/{id}','TeamController@delete_member');

Route::get('/tahap_team','TeamController@index');
Route::post('/lock_team','TeamController@lock_team');
Route::get('/tahap_profil','ProfilBisnisController@index');
Route::get('/product_abstract','ProdukController@index');
Route::get('/bmc','BmcController@index');

// tahap bmc
Route::get('/detail_bmc/{id}','BmcController@detail');
Route::post('/update_jawaban','BmcController@insertJawaban');
Route::get('/submit_bmc','BmcController@updateTrack');


// tahap prototype
Route::get('/proto','ProtoController@index');
Route::post('/setFigma','ProtoController@setFigma');
Route::post('/setLogo','ProtoController@setLogo');
Route::get('/submitProto','ProtoController@updateTrack');


// tahap publikasi
Route::get('/publikasi','PublikasiController@index');
Route::post('/setVideo','PublikasiController@setVideo');
Route::post('/setPoster','PublikasiController@setPoster');
Route::get('/submitPublikasi','PublikasiController@updateTrackPublikasi');

// tahap presentasi
Route::get('/presentasi','PresentasiController@index');
Route::get('/submitDeck','PresentasiController@updateTrackDeck');
Route::post('/setPitchDeck','PresentasiController@setDeck');


// mentor
Route::get('/mentor', 'MentorController@index');
Route::get('/mentor/login', 'MentorController@login');
Route::get('/mentor/logout', 'MentorController@logout');
Route::post('/mentor/signin', 'MentorController@signin');
Route::get('/mentor/penilaian', 'PenilaianController@index_mentor');
Route::get('/mentor/produk', 'ProdukController@getProduk');
Route::get('/mentor/detail_penilaian/{id}', 'PenilaianController@detail_penilaian');
Route::get('/mentor/detail_produk/{id}', 'ProdukController@detail_produk');
Route::post('/mentor/inputNilai', 'PenilaianController@inputNilai');
Route::post('/mentor/editNilai', 'PenilaianController@editNilai');
Route::post('/mentor/editTrack', 'ProdukController@editTrack');
Route::get('/mentor/detail_result_bmc/{id_bmc}/{id_produk}', 'BmcController@resultBMC');
Route::get('/mentor/feedback', 'FeedbackController@getFeedback');
