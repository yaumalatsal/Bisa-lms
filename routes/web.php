<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminProdukController;
use App\Http\Controllers\BmcController;
use App\Http\Controllers\Course\CourseController;
use App\Http\Controllers\Course\CourseMaterialController;
use App\Http\Controllers\Course\CourseQuestionController;
use App\Http\Controllers\Course\CourseSiswaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\GroupChatController;
use App\Http\Controllers\InvestorController;
use App\Http\Controllers\InvestorProdukController;
use App\Http\Controllers\MapelsQuizController;
use App\Http\Controllers\Mentor\MentorPameranController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\MonthlyReportController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\PeringkatController;
use App\Http\Controllers\PresentasiController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\ProtoController;
use App\Http\Controllers\PublikasiController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuizSoalController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Routes are grouped by audience: public (guest), siswa, mentor, investor and
| admin. Every non-public group is protected by server-side middleware.
|
*/

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/
Route::get('/login', [DashboardController::class, 'login'])->name('login');
Route::post('/signin', [SiswaController::class, 'login'])->middleware('throttle:10,1');
Route::get('/register_siswa', [DashboardController::class, 'register_siswa'])->name('register');
Route::post('/pendaftaran_siswa', [SiswaController::class, 'register_siswa'])->middleware('throttle:10,1');
Route::get('/logout_siswa', [SiswaController::class, 'logout']);

/*
|--------------------------------------------------------------------------
| Siswa
|--------------------------------------------------------------------------
*/
Route::middleware('auth.role:siswa')->group(function () {
    Route::get('/', [DashboardController::class, 'penilaian_siswa'])->name('dashboard.dashboard');

    // Peringkat
    Route::get('/peringkat', [PeringkatController::class, 'index'])->name('dashboard.ranking.index');
    Route::get('/peringkat/{mapelId}', [PeringkatController::class, 'getRankings'])->name('dashboard.ranking.data');
    Route::get('/points', [PeringkatController::class, 'showRankings'])->name('dashboard.ranking.point');

    // Group chat
    Route::get('/groupchat', [GroupChatController::class, 'index'])->name('dashboard.groupchat');
    Route::post('/groupchat/{id_product}', [GroupChatController::class, 'sendMessage'])->name('groupchat.sendMessage');

    // Kuis
    Route::get('/quiz', [QuizController::class, 'index'])->name('dashboard.quiz.index');
    Route::get('/quiz/{mapel_id}', [QuizController::class, 'showQuiz'])->name('dashboard.quiz.show');
    Route::post('/quiz/{mapel_id}/submit', [QuizController::class, 'submitQuiz'])->name('dashboard.quiz.submit');
    Route::get('/quiz/{mapel_id}/result', [QuizController::class, 'showResult'])->name('dashboard.quiz.result');

    // Inkubasi & materi
    Route::get('/inkubasi', [DashboardController::class, 'inkubasi'])->name('dashboard.inkubasi');
    Route::get('/materi/bmc', [DashboardController::class, 'showMateriBMC'])->name('dashboard.materi.bmc');
    Route::get('/materi/ide-bisnis', [DashboardController::class, 'showMateriIde'])->name('dashboard.materi.ide');
    Route::get('/materi/cara-memulai-bisnis', [DashboardController::class, 'showMateriCara'])->name('dashboard.materi.cara');

    // Laporan bulanan
    Route::get('/laporan', [MonthlyReportController::class, 'index'])->name('dashboard.laporan.index');
    Route::get('/laporan/create', [MonthlyReportController::class, 'create'])->name('dashboard.laporan.create');
    Route::post('/laporan', [MonthlyReportController::class, 'store'])->name('dashboard.laporan.store');
    Route::get('/laporan/edit/{id}', [MonthlyReportController::class, 'edit'])->name('dashboard.laporan.edit');
    Route::put('/laporan/update/{id}', [MonthlyReportController::class, 'update'])->name('dashboard.laporan.update');
    Route::delete('/laporan/{id}', [MonthlyReportController::class, 'destroy'])->name('dashboard.laporan.destroy');

    // Feedback & penilaian
    Route::get('/feedback', [FeedbackController::class, 'siswaFeedBack'])->name('dashboard.feedback');
    Route::post('/konfirmFeed', [FeedbackController::class, 'konfirmFeed'])->name('dashboard.feedback.confirm');
    Route::get('/penilaian', [PenilaianController::class, 'siswaPenilaian'])->name('dashboard.penilaian');

    // Monitoring bisnis
    Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring.index');

    // Produk
    Route::get('/produk', [ProdukController::class, 'siswaProduk'])->name('dashboard.produk');
    Route::get('/product_abstract', [ProdukController::class, 'index'])->name('dashboard.product_abstract');
    Route::post('/register_produk', [ProdukController::class, 'registerProduk'])->name('dashboard.produk.register');
    Route::get('/detail_result_bmc/{id_bmc}/{id_produk}', [BmcController::class, 'resultSiswaBMC'])
        ->name('dashboard.produk.result_bmc');

    // Tahap: tim & profil bisnis
    Route::get('/tahap_team', [TeamController::class, 'index'])->name('dashboard.tahap_team');
    Route::post('/cari_member', [SiswaController::class, 'searchByNis'])->name('dashboard.team.search');
    Route::post('/tambah_member', [TeamController::class, 'tambah_member'])->name('dashboard.team.add');
    Route::delete('/delete_member/{id}', [TeamController::class, 'delete_member'])->name('dashboard.team.delete');
    Route::post('/lock_team', [TeamController::class, 'lock_team'])->name('dashboard.team.lock');

    // Tahap: BMC
    Route::get('/bmc', [BmcController::class, 'index'])->name('dashboard.bmc');
    Route::get('/detail_bmc/{id}', [BmcController::class, 'detail'])->name('dashboard.bmc.detail');
    Route::post('/update_jawaban', [BmcController::class, 'insertJawaban'])->name('dashboard.bmc.answer');
    Route::post('/submit_bmc', [BmcController::class, 'updateTrack'])->name('dashboard.bmc.submit');

    // Tahap: prototype
    Route::get('/proto', [ProtoController::class, 'index'])->name('dashboard.proto');
    Route::post('/setFigma', [ProtoController::class, 'setFigma'])->name('dashboard.proto.figma');
    Route::post('/setLogo', [ProtoController::class, 'setLogo'])->name('dashboard.proto.logo');
    Route::post('/submitProto', [ProtoController::class, 'updateTrack'])->name('dashboard.proto.submit');

    // Tahap: publikasi
    Route::get('/publikasi', [PublikasiController::class, 'index'])->name('dashboard.publikasi');
    Route::post('/setVideo', [PublikasiController::class, 'setVideo'])->name('dashboard.publikasi.video');
    Route::post('/setPoster', [PublikasiController::class, 'setPoster'])->name('dashboard.publikasi.poster');
    Route::post('/submitPublikasi', [PublikasiController::class, 'updateTrackPublikasi'])->name('dashboard.publikasi.submit');

    // Tahap: presentasi
    Route::get('/presentasi', [PresentasiController::class, 'index'])->name('dashboard.presentasi');
    Route::post('/setPitchDeck', [PresentasiController::class, 'setDeck'])->name('dashboard.presentasi.deck');
    Route::post('/submitDeck', [PresentasiController::class, 'updateTrackDeck'])->name('dashboard.presentasi.submit');

    // Course
    Route::prefix('courses')->name('siswa.')->group(function () {
        Route::get('/', [CourseSiswaController::class, 'index'])->name('courses.index');
        Route::get('/materials/{materialId}', [CourseSiswaController::class, 'showMaterial'])->name('courses.showMaterial');
        Route::post('/materials/{material}/mark-read', [CourseSiswaController::class, 'markMaterialAsRead'])->name('materials.markRead');
        Route::get('/{courseId}/questions', [CourseQuestionController::class, 'showQuestions'])->name('courses.showQuestions');
        Route::post('/{courseid}/submit-answer', [CourseSiswaController::class, 'submitAnswers'])->name('courses.submitAnswers');
        Route::get('/{course}', [CourseSiswaController::class, 'show'])->name('courses.show');
    });

    // Profil
    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('siswa.profile');
    Route::post('/profile', [ProfileController::class, 'updateProfile'])->name('siswa.profile.update');
});

/*
|--------------------------------------------------------------------------
| Mentor
|--------------------------------------------------------------------------
*/
Route::prefix('mentor')->group(function () {
    Route::get('/login', [MentorController::class, 'login'])->name('mentor.login');
    Route::post('/signin', [MentorController::class, 'signin'])->middleware('throttle:10,1')->name('mentor.signin');
    Route::get('/logout', [MentorController::class, 'logout'])->name('mentor.logout');

    Route::middleware('auth.role:mentor')->group(function () {
        Route::get('/', [MentorController::class, 'index'])->name('mentor.index');

        Route::get('/laporan-produk', [MentorController::class, 'laporanNilai'])->name('mentor.page.laporan_produk');
        Route::post('/laporan_produk/approve/{id}', [MentorController::class, 'approveReport'])->name('mentor.page.laporan_produk.approve');
        Route::post('/laporan_produk/reject/{id}', [MentorController::class, 'rejectReport'])->name('mentor.page.laporan_produk.reject');

        Route::get('/penilaian', [PenilaianController::class, 'index_mentor'])->name('mentor.penilaian');
        Route::get('/detail_penilaian/{id}', [PenilaianController::class, 'detail_penilaian'])->name('mentor.detail_penilaian');
        Route::post('/inputNilai', [PenilaianController::class, 'inputNilai'])->name('mentor.inputNilai');
        Route::post('/editNilai', [PenilaianController::class, 'editNilai'])->name('mentor.editNilai');
        Route::post('/deleteNilai', [PenilaianController::class, 'deleteNilai'])->name('mentor.deleteNilai');

        Route::get('/produk', [ProdukController::class, 'getProduk'])->name('mentor.produk');
        Route::get('/detail_produk/{id}', [ProdukController::class, 'detail_produk'])->name('mentor.detail_produk');
        Route::post('/editTrack', [ProdukController::class, 'editTrack'])->name('mentor.editTrack');
        Route::get('/detail_result_bmc/{id_bmc}/{id_produk}', [BmcController::class, 'resultBMC'])->name('mentor.result_bmc');

        Route::get('/feedback', [FeedbackController::class, 'getFeedback'])->name('mentor.feedback');

        Route::get('/groupchat/{id_produk}', [GroupChatController::class, 'mentor'])->name('mentor.page.groupchat');
        Route::post('/groupchat/{id_produk}', [GroupChatController::class, 'sendMessageMentor'])->name('groupchat.sendMessageMentor');

        // Pameran — rute yang lebih spesifik didaftarkan lebih dulu.
        Route::get('/pameran', [MentorPameranController::class, 'index'])->name('mentor.pameran.index');
        Route::get('/pameran/monitoring/{product_id}', [MonitoringController::class, 'mentorMonitoring'])->name('mentor.pameran.monitoring');
        Route::get('/pameran/{id_bmc}/{id_produk}', [MentorPameranController::class, 'result_bmc'])->name('mentor.pameran.result_bmc');
        Route::get('/pameran/{id}', [MentorPameranController::class, 'detail'])->name('mentor.pameran.detail');

        // Course. Resource routes are limited to the actions the controllers
        // actually implement — the full resource registered show/create/edit
        // endpoints that had no method behind them and returned 500.
        Route::resource('courses', CourseController::class);
        Route::resource('courses/{course}/materials', CourseMaterialController::class)
            ->except(['show']);
        Route::prefix('courses/{course_id}')->name('course.')->group(function () {
            Route::resource('questions', CourseQuestionController::class)
                ->only(['index', 'store', 'update', 'destroy']);
        });
        Route::get('/courses/{courseId}/answers', [CourseQuestionController::class, 'showAnswers'])->name('mentor.answers.index');
        Route::post('/courses/{courseId}/answers/{answerId}/update-score', [CourseQuestionController::class, 'updateScore'])->name('mentor.answers.updateScore');
    });
});

/*
|--------------------------------------------------------------------------
| Investor
|--------------------------------------------------------------------------
*/
Route::prefix('investor')->name('investor.')->group(function () {
    Route::get('login', [InvestorController::class, 'showLoginForm'])->name('login');
    Route::post('login', [InvestorController::class, 'login'])->middleware('throttle:10,1')->name('login-process');
    Route::get('register', [InvestorController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [InvestorController::class, 'register'])->middleware('throttle:10,1')->name('register-process');
    Route::get('logout', [InvestorController::class, 'logout'])->name('logout');

    Route::middleware('auth:investor')->group(function () {
        Route::get('/', [InvestorController::class, 'index'])->name('index');
        Route::get('/produk', [InvestorProdukController::class, 'index'])->name('produk');
        Route::get('/produk/monitoring/{product_id}', [MonitoringController::class, 'investorMonitoring'])->name('produk.monitoring');
        Route::get('/produk/{id_bmc}/{id_produk}', [InvestorProdukController::class, 'result_bmc'])->name('produk.result_bmc');
        Route::get('/produk/{id}', [InvestorProdukController::class, 'detail'])->name('produk.detail');
    });
});

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AdminController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AdminController::class, 'login'])->middleware('throttle:10,1')->name('login-process');
    Route::get('logout', [AdminController::class, 'logout'])->name('logout');

    Route::middleware('auth:admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');

        // Produk — rute yang lebih spesifik didaftarkan lebih dulu.
        Route::get('/produk', [AdminProdukController::class, 'index'])->name('produk');
        Route::get('/produk/{id_bmc}/{id_produk}', [AdminProdukController::class, 'result_bmc'])->name('produk.result_bmc');
        Route::get('/produk/{id}', [AdminProdukController::class, 'detail'])->name('produk.detail');
        Route::delete('/produk/{id}', [AdminProdukController::class, 'destroy'])->name('produk.destroy');

        Route::get('/siswa', [AdminController::class, 'showSiswa'])->name('siswa');
        Route::delete('/siswa/{id}', [AdminController::class, 'destroySiswa'])->name('siswa.destroy');

        // Materi
        Route::get('/materi', [AdminController::class, 'showMateri'])->name('materi.index');
        Route::get('/materi/create', [AdminController::class, 'createMateri'])->name('materi.create');
        Route::post('/materi', [AdminController::class, 'storeMateri'])->name('materi.store');
        Route::get('/materi/{id}/edit', [AdminController::class, 'editMateri'])->name('materi.edit');
        Route::put('/materi/{id}', [AdminController::class, 'updateMateri'])->name('materi.update');
        Route::delete('/materi/{id}', [AdminController::class, 'destroyMateri'])->name('materi.destroy');

        // Mapel & soal kuis — rute statis didaftarkan sebelum rute berparameter.
        Route::get('/mapel', [MapelsQuizController::class, 'index'])->name('mapels.index');
        Route::get('/mapel/create', [MapelsQuizController::class, 'create'])->name('mapels.create');
        Route::post('/mapel', [MapelsQuizController::class, 'store'])->name('mapels.store');
        Route::get('/mapel/soal', [QuizSoalController::class, 'index'])->name('quiz_soals.index');
        Route::get('/mapel/soal/create', [QuizSoalController::class, 'create'])->name('quiz_soals.create');
        Route::post('/mapel/soal', [QuizSoalController::class, 'store'])->name('quiz_soals.store');
        Route::get('/mapel/soal/{id}/edit', [QuizSoalController::class, 'edit'])->name('quiz_soals.edit');
        Route::put('/mapel/soal/{id}', [QuizSoalController::class, 'update'])->name('quiz_soals.update');
        Route::delete('/mapel/soal/{id}', [QuizSoalController::class, 'destroy'])->name('quiz_soals.destroy');
        Route::get('/mapel/{id}/edit', [MapelsQuizController::class, 'edit'])->name('mapels.edit');
        Route::put('/mapel/{id}', [MapelsQuizController::class, 'update'])->name('mapels.update');
        Route::delete('/mapel/{id}', [MapelsQuizController::class, 'destroy'])->name('mapels.destroy');

        // BMC
        Route::get('/bmc', [AdminController::class, 'bmc'])->name('bmc.index');
        Route::get('/bmc/create', [AdminController::class, 'bmcCreate'])->name('bmc.create');
        Route::post('/bmc', [AdminController::class, 'bmcStore'])->name('bmc.store');
        Route::get('/bmc/{id}/edit', [AdminController::class, 'bmcEdit'])->name('bmc.edit');
        Route::put('/bmc/{id}', [AdminController::class, 'bmcUpdate'])->name('bmc.update');
        Route::delete('/bmc/{id}', [AdminController::class, 'bmcDestroy'])->name('bmc.destroy');

        // Soal BMC
        Route::get('/bmc/{id}/soal', [AdminController::class, 'kelolaSoal'])->name('bmc.soal.index');
        Route::get('/bmc/{id}/soal/create', [AdminController::class, 'soalCreate'])->name('bmc.soal.create');
        Route::post('/bmc/{id}/soal', [AdminController::class, 'soalStore'])->name('bmc.soal.store');
        Route::get('/bmc/{id}/soal/{soalId}/edit', [AdminController::class, 'soalEdit'])->name('bmc.soal.edit');
        Route::put('/bmc/{id}/soal/{soalId}', [AdminController::class, 'soalUpdate'])->name('bmc.soal.update');
        Route::delete('/bmc/{id}/soal/{soalId}', [AdminController::class, 'soalDestroy'])->name('bmc.soal.destroy');
    });
});
