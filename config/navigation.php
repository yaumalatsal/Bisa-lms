<?php

/*
|--------------------------------------------------------------------------
| Sidebar navigation
|--------------------------------------------------------------------------
|
| One definition per role, consumed by resources/views/layouts/app.blade.php.
| The four roles used to keep four hand-maintained sidebar partials, which had
| drifted: the admin menu linked to /admin/penilaian and /admin/feedback and the
| investor menu to /investor/penilaian and /investor/feedback, none of which are
| registered routes. Those dead entries are gone.
|
| Each item:
|   label   Menu text.
|   icon    Material Design Icons class (the vendor icon font already loaded).
|   route   Named route, OR
|   url     Absolute path when there is no name.
|   active  request()->is() pattern(s) marking the item current.
|   when    Optional closure; the item renders only when it returns true.
|
*/

return [

    'siswa' => [
        'label' => 'Siswa',
        'title' => 'BISa',
        'home' => '/',
        'profile' => '/profile',
        'logout' => '/logout_siswa',
        'items' => [
            ['label' => 'Dashboard', 'icon' => 'mdi-home', 'url' => '/', 'active' => '/'],
            [
                'label' => 'Produk',
                'icon' => 'mdi-cube-outline',
                'url' => '/produk',
                'active' => 'produk',
                // Only meaningful once the siswa belongs to a team.
                'when' => fn () => (bool) session('id_produk'),
            ],
            ['label' => 'Course', 'icon' => 'mdi-book', 'url' => '/courses', 'active' => 'courses*'],
            ['label' => 'Inkubasi', 'icon' => 'mdi-lightbulb-on-outline', 'url' => '/inkubasi', 'active' => 'inkubasi'],
            ['label' => 'Laporan Bulanan', 'icon' => 'mdi-file-document', 'url' => '/laporan', 'active' => 'laporan*'],
            ['label' => 'Monitoring Bisnis', 'icon' => 'mdi-chart-line', 'url' => '/monitoring', 'active' => 'monitoring'],
            ['label' => 'Feedback Mentor', 'icon' => 'mdi-message-text', 'url' => '/feedback', 'active' => 'feedback'],
            ['label' => 'Penilaian', 'icon' => 'mdi-star', 'url' => '/penilaian', 'active' => 'penilaian'],
            ['label' => 'Kuis', 'icon' => 'mdi-puzzle', 'url' => '/quiz', 'active' => 'quiz*'],
            ['label' => 'Ranking Quiz', 'icon' => 'mdi-trophy', 'url' => '/peringkat', 'active' => 'peringkat*'],
            ['label' => 'Ranking Point', 'icon' => 'mdi-trophy-award', 'url' => '/points', 'active' => 'points'],
            ['label' => 'Group Chat', 'icon' => 'mdi-forum', 'url' => '/groupchat', 'active' => 'groupchat'],
        ],
    ],

    'mentor' => [
        'label' => 'Mentor',
        'title' => 'BISa Mentor',
        'home' => '/mentor',
        'profile' => null,
        'logout' => '/mentor/logout',
        'items' => [
            ['label' => 'Dashboard', 'icon' => 'mdi-view-dashboard', 'url' => '/mentor', 'active' => 'mentor'],
            ['label' => 'Produk Bimbingan', 'icon' => 'mdi-buffer', 'url' => '/mentor/produk', 'active' => 'mentor/produk*'],
            ['label' => 'Pameran', 'icon' => 'mdi-store', 'url' => '/mentor/pameran', 'active' => 'mentor/pameran*'],
            ['label' => 'Course', 'icon' => 'mdi-book', 'url' => '/mentor/courses', 'active' => 'mentor/courses*'],
            ['label' => 'Penilaian', 'icon' => 'mdi-star', 'url' => '/mentor/penilaian', 'active' => ['mentor/penilaian', 'mentor/detail_penilaian*']],
            ['label' => 'Feedback', 'icon' => 'mdi-comment-check', 'url' => '/mentor/feedback', 'active' => 'mentor/feedback'],
            ['label' => 'Laporan Bulanan', 'icon' => 'mdi-file-document', 'url' => '/mentor/laporan-produk', 'active' => 'mentor/laporan*'],
        ],
    ],

    'admin' => [
        'label' => 'Admin',
        'title' => 'BISa Admin',
        'home' => '/admin',
        'profile' => null,
        'logout' => '/admin/logout',
        'items' => [
            ['label' => 'Dashboard', 'icon' => 'mdi-view-dashboard', 'route' => 'admin.index', 'active' => 'admin'],
            ['label' => 'Produk', 'icon' => 'mdi-buffer', 'route' => 'admin.produk', 'active' => 'admin/produk*'],
            ['label' => 'Siswa', 'icon' => 'mdi-account-multiple', 'route' => 'admin.siswa', 'active' => 'admin/siswa*'],
            ['label' => 'Daftar Materi', 'icon' => 'mdi-book-open-variant', 'route' => 'admin.materi.index', 'active' => 'admin/materi*'],
            ['label' => 'Soal Quiz', 'icon' => 'mdi-help-circle-outline', 'route' => 'admin.mapels.index', 'active' => 'admin/mapel*'],
            ['label' => 'Pertanyaan BMC', 'icon' => 'mdi-view-grid', 'route' => 'admin.bmc.index', 'active' => 'admin/bmc*'],
        ],
    ],

    'investor' => [
        'label' => 'Investor',
        'title' => 'BISa Investor',
        'home' => '/investor',
        'profile' => null,
        'logout' => '/investor/logout',
        'items' => [
            ['label' => 'Dashboard', 'icon' => 'mdi-view-dashboard', 'route' => 'investor.index', 'active' => 'investor'],
            ['label' => 'Pameran Produk', 'icon' => 'mdi-buffer', 'route' => 'investor.produk', 'active' => 'investor/produk*'],
        ],
    ],

];
