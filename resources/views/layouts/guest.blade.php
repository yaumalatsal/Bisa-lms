{{--
    Shell for the signed-out pages (login, registration).

    There used to be four of these — one per role — each a full HTML document
    with ~130 lines of copy-pasted inline CSS and a Bootstrap 4 build pulled
    from a retired CDN host. This is the only one now; roles differ by the
    content they pass in.
--}}
@php
    $authTitle = trim($__env->yieldContent('auth-title')) ?: 'Masuk';
@endphp
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="BISa — platform inkubasi dan monitoring bisnis mahasiswa Universitas Negeri Malang.">
    <title>{{ $authTitle }} · BISa</title>

    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/logo_bisa.png') }}">
    <link href="{{ asset('matrix/dist/css/style.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bisa.css') }}" rel="stylesheet">

    <style>
        .auth {
            display: grid;
            grid-template-columns: 1.05fr 1fr;
            min-height: 100vh;
            background: var(--bisa-bg);
        }

        .auth__hero {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: var(--bisa-space-5);
            padding: var(--bisa-space-7);
            color: #fff;
            background:
                linear-gradient(140deg, rgba(49, 46, 129, 0.94), rgba(79, 70, 229, 0.88)),
                url('{{ asset('assets/images/bg_new.jpg') }}') center / cover no-repeat;
        }

        .auth__hero h1 {
            color: #fff;
            font-size: clamp(2rem, 3.4vw, 3rem);
            line-height: 1.1;
            margin: 0;
        }

        .auth__hero p {
            color: rgba(255, 255, 255, 0.86);
            font-size: 1.0625rem;
            max-width: 46ch;
            margin: 0;
        }

        .auth__logo { height: 44px; width: auto; }

        .auth__points { list-style: none; padding: 0; margin: 0; display: grid; gap: var(--bisa-space-3); }

        .auth__points li {
            display: flex;
            align-items: flex-start;
            gap: var(--bisa-space-3);
            color: rgba(255, 255, 255, 0.9);
        }

        .auth__points i { margin-top: 3px; }

        .auth__panel {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: var(--bisa-space-6) var(--bisa-space-5);
        }

        .auth__card {
            width: 100%;
            max-width: 420px;
            background: var(--bisa-surface);
            border: 1px solid var(--bisa-border);
            border-radius: var(--bisa-radius-lg);
            box-shadow: var(--bisa-shadow);
            padding: var(--bisa-space-6);
        }

        .auth__eyebrow {
            color: var(--bisa-primary);
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .auth__title { font-size: 1.5rem; margin: var(--bisa-space-2) 0 var(--bisa-space-1); }
        .auth__lead { color: var(--bisa-text-muted); margin-bottom: var(--bisa-space-5); }

        .auth__switch {
            display: flex;
            flex-wrap: wrap;
            gap: var(--bisa-space-2);
            margin-top: var(--bisa-space-5);
            padding-top: var(--bisa-space-4);
            border-top: 1px solid var(--bisa-border);
        }

        .auth__switch-label {
            width: 100%;
            color: var(--bisa-text-subtle);
            font-size: 0.8125rem;
            margin-bottom: var(--bisa-space-1);
        }

        @media (max-width: 900px) {
            .auth { grid-template-columns: 1fr; }
            .auth__hero { padding: var(--bisa-space-6) var(--bisa-space-5); gap: var(--bisa-space-4); }
            .auth__hero p, .auth__points { display: none; }
            .auth__panel { padding: var(--bisa-space-5) var(--bisa-space-4) var(--bisa-space-7); }
        }
    </style>

    @stack('styles')
    @yield('css')
</head>

<body>
    <div class="auth">
        <section class="auth__hero">
            <img class="auth__logo" src="{{ asset('assets/images/logo_fix.png') }}" alt="BISa">
            <h1>Inkubasi bisnis, dari ide sampai pameran.</h1>
            <p>BISa mendampingi mahasiswa Universitas Negeri Malang menyusun model bisnis,
                melaporkan perkembangan, dan mempertemukannya dengan mentor serta investor.</p>
            <ul class="auth__points">
                <li><i class="mdi mdi-check-circle" aria-hidden="true"></i><span>Susun Business Model Canvas bersama tim</span></li>
                <li><i class="mdi mdi-check-circle" aria-hidden="true"></i><span>Laporkan penjualan dan profit tiap bulan</span></li>
                <li><i class="mdi mdi-check-circle" aria-hidden="true"></i><span>Dapat umpan balik langsung dari mentor</span></li>
            </ul>
        </section>

        <section class="auth__panel">
            <div class="auth__card">
                @include('layouts.partials.flash')
                @yield('content')
            </div>
        </section>
    </div>

    <script src="{{ asset('matrix/assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('matrix/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/bisa.js') }}"></script>

    @stack('scripts')
    @yield('js')
</body>

</html>
