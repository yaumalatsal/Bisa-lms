@php
    use Illuminate\Support\Facades\Auth;

    /*
     | One shell for all four roles. `$navRole` is set by the thin role layouts
     | in resources/views/{dashboard_template,admin,mentor,investor}; when a view
     | extends this directly we derive the role from whichever guard is signed in.
     */
    $navRole = $navRole ?? collect(['admin', 'mentor', 'investor', 'siswa'])
        ->first(fn ($guard) => Auth::guard($guard)->check()) ?? 'siswa';

    $nav = config("navigation.$navRole", config('navigation.siswa'));

    $user = Auth::guard($navRole)->user();
    $userName = $user->nama ?? $user->name ?? $nav['label'];
    $initials = collect(preg_split('/\s+/', trim((string) $userName)))
        ->filter()
        ->take(2)
        ->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))
        ->implode('') ?: 'B';

    $pageTitle = trim($__env->yieldContent('title-page'));
@endphp
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex,nofollow">
    <meta name="description" content="BISa — platform inkubasi dan monitoring bisnis mahasiswa.">
    <title>{{ $pageTitle ? $pageTitle . ' · ' : '' }}{{ $nav['title'] }}</title>

    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/logo_bisa.png') }}">

    {{-- Vendor theme: grid, icon fonts, base components. --}}
    <link href="{{ asset('matrix/dist/css/style.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.css">
    {{-- BISa design system: everything visual above the vendor substrate. --}}
    <link href="{{ \App\Support\Asset::versioned('css/bisa.css') }}" rel="stylesheet">

    @stack('styles')
    @yield('css')
</head>

<body>
    <a class="bisa-skip-link" href="#bisa-main">Lewati ke konten utama</a>

    <div id="main-wrapper" data-sidebartype="full">
        @include('layouts.partials.topbar')
        @include('layouts.partials.sidebar')

        <div class="page-wrapper">
            <div class="container-fluid py-4">
                @if ($pageTitle)
                    <div class="bisa-page-header">
                        <div>
                            <h1 class="bisa-page-header__title">{{ $pageTitle }}</h1>
                            @hasSection('page-subtitle')
                                <p class="bisa-page-header__subtitle">@yield('page-subtitle')</p>
                            @endif
                        </div>
                        @hasSection('page-actions')
                            <div class="bisa-actions">@yield('page-actions')</div>
                        @endif
                    </div>
                @endif

                @include('layouts.partials.flash')

                <main id="bisa-main">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    {{-- Loaded in dependency order and NOT deferred: page views append inline
         scripts through @yield('js') that call into jQuery/DataTables directly. --}}
    <script src="{{ asset('matrix/assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('matrix/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ \App\Support\Asset::versioned('js/bisa.js') }}"></script>

    @stack('scripts')
    @yield('js')
</body>

</html>
