<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminProdukController;
use App\Http\Controllers\Course\CourseController;
use App\Http\Controllers\Course\CourseMaterialController;
use App\Http\Controllers\Course\CourseQuestionController;
use App\Http\Controllers\Course\CourseSiswaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MonthlyReportController;
use App\Http\Controllers\MentorController;
use App\Models\MonthlyReport;
use App\Http\Controllers\InvestorController;
use App\Http\Controllers\InvestorProdukController;
use App\Http\Controllers\MapelsQuizController;
use App\Http\Controllers\QuizSoalController;
use App\Http\Controllers\QuizController;

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

use App\Http\Controllers\PeringkatController;
use App\Http\Controllers\GroupChatController;
use App\Http\Controllers\Mentor\MentorPameranController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\Profile\ProfileController;

Route::get('/peringkat', [PeringkatController::class, 'index'])->name('dashboard.ranking.index');
Route::get('/peringkat/{mapelId}', [PeringkatController::class, 'getRankings'])->name('dashboard.ranking.data');
Route::get('/points', [PeringkatController::class, 'showRankings'])->name('dashboard.ranking.point');




//GROUP CHAT
Route::get('/groupchat', [GroupChatController::class, 'index'])->name('dashboard.groupchat');
Route::post('groupchat/{id_product}', [GroupChatController::class, 'sendMessage'])->name('groupchat.sendMessage');

// Route::get('/groupchat', [GroupChatController::class, 'mentor'])->name('mentor.page.groupchat');
// Route::post('groupchat-mentor/{id_product}', [GroupChatController::class, 'sendMessageMentor'])->name('groupchat.sendMessage');

Route::get('/groupchat-mentor/{id_produk}', [GroupChatController::class, 'mentor'])->name('mentor.page.groupchat');
Route::post('/groupchat-mentor/{id_produk}', [GroupChatController::class, 'sendMessageMentor'])->name('groupchat.sendMessageMentor');

//QUIZ
Route::get('/quiz', [QuizController::class, 'index'])->name('dashboard.quiz.index');

Route::get('/quiz/{mapel_id}', [QuizController::class, 'showQuiz'])->name('dashboard.quiz.show');
Route::post('/quiz/{mapel_id}/submit', [QuizController::class, 'submitQuiz'])->name('dashboard.quiz.submit');
Route::get('/quiz/{mapel_id}/result', [QuizController::class, 'showResult'])->name('dashboard.quiz.result');



Route::get('/', [DashboardController::class, 'penilaian_siswa'])->name('dashboard.dashboard');

Route::get('/artikel/bmc', function () {
    return view('artikel.bmc');
});

// Route::get('/inkubasi', 'DashboardController@inkubasi');
Route::get('/inkubasi', [DashboardController::class, 'inkubasi'])->name('dashboard.inkubasi');
Route::get('/laporan', [DashboardController::class, 'laporan'])->name('dashboard.laporan');
// Display the list of reports
Route::get('/laporan', [MonthlyReportController::class, 'index'])->name('dashboard.laporan.index');
Route::get('/laporan/create', [MonthlyReportController::class, 'create'])->name('dashboard.laporan.create');
Route::post('/laporan', [MonthlyReportController::class, 'store'])->name('dashboard.laporan.store');
Route::get('/laporan/edit/{id}', [MonthlyReportController::class, 'edit'])->name('dashboard.laporan.edit');
Route::put('/laporan/update/{id}', [MonthlyReportController::class, 'update'])->name('dashboard.laporan.update');


Route::delete('/laporan/{id}', [MonthlyReportController::class, 'destroy'])->name('dashboard.laporan.destroy');


// // Autentifikasi
Route::get('/register_mentor', 'DashboardController@register_mentor');
Route::get('/register_siswa', 'DashboardController@register_siswa');
Route::post('/pendaftaran_siswa', 'SiswaController@register_siswa');
Route::get('/logout_siswa', 'SiswaController@logout');
Route::post('/signin', 'SiswaController@login');
// Route::get('/dashboard', 'DashboardController@index');
Route::get('/login', 'DashboardController@login')->name('login');

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
Route::post('/tambah_member', 'TeamController@tambah_member');
Route::get('/delete_member/{id}', 'TeamController@delete_member');

Route::get('/tahap_team', 'TeamController@index');
Route::post('/lock_team', 'TeamController@lock_team');
Route::get('/tahap_profil', 'ProfilBisnisController@index');
Route::get('/product_abstract', 'ProdukController@index');
Route::get('/bmc', 'BmcController@index');

// tahap bmc
Route::get('/detail_bmc/{id}', 'BmcController@detail');
Route::post('/update_jawaban', 'BmcController@insertJawaban');
Route::get('/submit_bmc', 'BmcController@updateTrack');


// tahap prototype
Route::get('/proto', 'ProtoController@index');
Route::post('/setFigma', 'ProtoController@setFigma');
Route::post('/setLogo', 'ProtoController@setLogo');
Route::get('/submitProto', 'ProtoController@updateTrack');


// tahap publikasi
Route::get('/publikasi', 'PublikasiController@index');
Route::post('/setVideo', 'PublikasiController@setVideo');
Route::post('/setPoster', 'PublikasiController@setPoster');
Route::get('/submitPublikasi', 'PublikasiController@updateTrackPublikasi');

// tahap presentasi
Route::get('/presentasi', 'PresentasiController@index');
Route::get('/submitDeck', 'PresentasiController@updateTrackDeck');
Route::post('/setPitchDeck', 'PresentasiController@setDeck');

// Course Siswa
Route::prefix('courses')->name('siswa.')->group(function () {
    Route::get('/', [CourseSiswaController::class, 'index'])->name('courses.index');
    Route::get('/{course}', [CourseSiswaController::class, 'show'])->name('courses.show');
    Route::get('/materials/{materialId}', [CourseSiswaController::class, 'showMaterial'])->name('courses.showMaterial');
    Route::post('materials/{material}/mark-read', [CourseSiswaController::class, 'markMaterialAsRead'])->name('materials.markRead');
    Route::get('/{courseId}/questions', [CourseQuestionController::class, 'showQuestions'])->name('courses.showQuestions');
    Route::post('/{courseid}/submit-answer', [CourseSiswaController::class, 'submitAnswers'])->name('courses.submitAnswers');
});

Route::get('/profile', [ProfileController::class, 'showProfile'])->name('siswa.profile');
Route::post('/profile', [ProfileController::class, 'updateProfile'])->name('siswa.profile.update');



// mentor
Route::get('/mentor', 'MentorController@index');
Route::get('/mentor/login', 'MentorController@login');
Route::get('/mentor/logout', 'MentorController@logout');
Route::post('/mentor/signin', 'MentorController@signin');
Route::get('/mentor/laporan-produk', 'MentorController@laporanNilai');
Route::post('mentor/laporan_produk/approve/{id}', 'MentorController@approveReport');
Route::post('mentor/laporan_produk/approve/{id}', 'MentorController@rejectReport');


Route::post('mentor/laporan_produk/approve/{id}', [MentorController::class, 'approveReport'])->name('mentor.page.laporan_produk.approve');
Route::post('mentor/laporan_produk/reject/{id}', [MentorController::class, 'rejectReport'])->name('mentor.page.laporan_produk.reject');


Route::get('/mentor/penilaian', 'PenilaianController@index_mentor');
Route::get('/mentor/produk', 'ProdukController@getProduk');
Route::get('/mentor/detail_penilaian/{id}', 'PenilaianController@detail_penilaian');
Route::get('/mentor/detail_produk/{id}', 'ProdukController@detail_produk');
Route::post('/mentor/inputNilai', 'PenilaianController@inputNilai');
Route::post('/mentor/editNilai', 'PenilaianController@editNilai');
Route::post('/mentor/editTrack', 'ProdukController@editTrack');
Route::post('/mentor/deleteNilai', [PenilaianController::class, 'deleteNilai']);

Route::get('/mentor/detail_result_bmc/{id_bmc}/{id_produk}', 'BmcController@resultBMC');
Route::get('/mentor/feedback', 'FeedbackController@getFeedback');

Route::resource('mentor/courses', CourseController::class);
Route::resource('mentor/courses/{course}/materials', CourseMaterialController::class);
Route::prefix('mentor/courses/{course_id}')->name('course.')->group(function () {
    Route::resource('questions', CourseQuestionController::class);
});
Route::get('/mentor/courses/{courseId}/answers', [CourseQuestionController::class, 'showAnswers'])->name('mentor.answers.index');
Route::post('/courses/{courseId}/answers/{answerId}/update-score', [CourseQuestionController::class, 'updateScore'])->name('mentor.answers.updateScore');


Route::get('/mentor/pameran', [MentorPameranController::class, 'index'])->name('mentor.pameran.index');
Route::get('/mentor/pameran/{id}', [MentorPameranController::class, 'detail'])->name('mentor.pameran.detail');
Route::get('/mentor/pameran/monitoring/{product_id}', [MonitoringController::class, 'mentorMonitoring'])->name('mentor.pameran.monitoring');
Route::get('/mentor/pameran/{id_bmc}/{id_produk}', [MentorPameranController::class, 'result_bmc'])->name('mentor.pameran.result_bmc');





// investor
Route::prefix('investor')->name('investor.')->group(function () {
    Route::get('login', [InvestorController::class, 'showLoginForm'])->name('login');
    Route::post('login', [InvestorController::class, 'login'])->name('login-process');
    Route::get('register', [InvestorController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [InvestorController::class, 'register'])->name('register-process');
    Route::get('logout', [InvestorController::class, 'logout'])->name('logout');

    Route::middleware(['auth:investor'])->group(function () {
        Route::get('/', [InvestorController::class, 'index'])->name('index');
        Route::get('/produk', [InvestorProdukController::class, 'index'])->name('produk');
        Route::get('/produk/{id}', [InvestorProdukController::class, 'detail'])->name('produk.detail');
        Route::get('/produk/monitoring/{product_id}', [MonitoringController::class, 'investorMonitoring'])->name('produk.monitoring');
        Route::get('/produk/{id_bmc}/{id_produk}', [InvestorProdukController::class, 'result_bmc'])->name('produk.result_bmc');
    });
});

// Route::get('/admin/materi', [AdminController::class,'showMateri'])->name('admin.materi');
Route::get('/materi/bmc', [DashboardController::class, 'showMateriBMC'])->name('dashboard.materi.bmc');
Route::get('/materi/ide-bisnis', [DashboardController::class, 'showMateriIde'])->name('dashboard.materi.ide');
Route::get('/materi/cara-memulai-bisnis', [DashboardController::class, 'showMateriCara'])->name('dashboard.materi.cara');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AdminController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AdminController::class, 'login'])->name('login-process');
    Route::get('logout', [AdminController::class, 'logout'])->name('logout');


    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/produk', [AdminProdukController::class, 'index'])->name('produk');
        Route::get('/produk/{id}', [AdminProdukController::class, 'detail'])->name('produk.detail');
        Route::get('/produk/{id_bmc}/{id_produk}', [AdminProdukController::class, 'result_bmc'])->name('produk.result_bmc');
        Route::delete('/produk/{id}', [AdminProdukController::class, 'destroy'])->name('produk.destroy');


        Route::get('/siswa', [AdminController::class, 'showSiswa'])->name('siswa');
        Route::delete('/siswa/{id}', [AdminController::class, 'destroySiswa'])->name('siswa.destroy');

        //Materi
        Route::get('/materi/create', [AdminController::class, 'createMateri'])->name('materi.create');
        Route::post('/materi', [AdminController::class, 'storeMateri'])->name('materi.store');
        Route::get('/materi/{id}/edit', [AdminController::class, 'editMateri'])->name('materi.edit');
        Route::put('/materi/{id}', [AdminController::class, 'updateMateri'])->name('materi.update');
        Route::delete('/materi/{id}', [AdminController::class, 'destroyMateri'])->name('materi.destroy');

        Route::get('/mapel', [MapelsQuizController::class, 'index'])->name('mapels.index');
        Route::get('/mapel/create', [MapelsQuizController::class, 'create'])->name('mapels.create');
        Route::post('/mapel', [MapelsQuizController::class, 'store'])->name('mapels.store');
        Route::get('/mapel/{id}/edit', [MapelsQuizController::class, 'edit'])->name('mapels.edit');
        Route::put('/mapel/{id}', [MapelsQuizController::class, 'update'])->name('mapels.update');
        Route::delete('/mapel/{id}', [MapelsQuizController::class, 'destroy'])->name('mapels.destroy');

        // Rute CRUD untuk soal kuis di dalam mapel

        Route::get('/mapel/soal', [QuizSoalController::class, 'index'])->name('quiz_soals.index');
        Route::get('/mapel/soal/create', [QuizSoalController::class, 'create'])->name('quiz_soals.create');
        Route::post('/mapel/soal/', [QuizSoalController::class, 'store'])->name('quiz_soals.store');
        Route::get('/mapel/soal/{id}/edit', [QuizSoalController::class, 'edit'])->name('quiz_soals.edit');
        Route::put('/mapel/soal/{id}', [QuizSoalController::class, 'update'])->name('quiz_soals.update');
        Route::delete('/mapel/soal/{id}', [QuizSoalController::class, 'destroy'])->name('quiz_soals.destroy');

        //bmc
        Route::get('/bmc', [AdminController::class, 'bmc'])->name('bmc.index');
        Route::get('/bmc/create', [AdminController::class, 'bmcCreate'])->name('bmc.create');
        Route::post('/bmc', [AdminController::class, 'bmcStore'])->name('bmc.store');
        Route::get('/bmc/{id}/edit', [AdminController::class, 'bmcEdit'])->name('bmc.edit');
        Route::put('/bmc/{id}', [AdminController::class, 'bmcUpdate'])->name('bmc.update');
        Route::delete('/bmc/{id}', [AdminController::class, 'bmcDestroy'])->name('bmc.destroy');
        // Route::get('/bmc/{id}/subsoal', [AdminController::class, 'bmcSubsoal'])->name('bmc.subsoal');

        //soal bmc
        // Routes untuk mengelola soal
        Route::get('/bmc/{id}/soal', [AdminController::class, 'kelolaSoal'])->name('bmc.soal.index');

        // Create Soal
        Route::get('/bmc/{id}/soal/create', [AdminController::class, 'soalCreate'])->name('bmc.soal.create');
        Route::post('/bmc/{id}/soal', [AdminController::class, 'soalStore'])->name('bmc.soal.store');

        // Edit Soal
        Route::get('/bmc/{id}/soal/{soalId}/edit', [AdminController::class, 'soalEdit'])->name('bmc.soal.edit');
        Route::put('/bmc/{id}/soal/{soalId}', [AdminController::class, 'soalUpdate'])->name('bmc.soal.update');

        // Hapus Soal
        Route::delete('/bmc/{id}/soal/{soalId}', [AdminController::class, 'soalDestroy'])->name('bmc.soal.destroy');




        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/materi', [AdminController::class, 'showMateri'])->name('admin.showMateri');
    });
});
