{{--
    Shared shell for error pages. Laravel's stock pages are unstyled Symfony
    defaults, which made a 403 or 404 look like the app had fallen over.

    `$code`, `$title` and `$body` come from the individual error views.
    `$back` is worked out from whichever guard is signed in, so "kembali" lands
    somewhere the visitor can actually reach.
--}}
@php
    use Illuminate\Support\Facades\Auth;

    $role = collect(['admin', 'mentor', 'investor', 'siswa'])
        ->first(fn ($guard) => Auth::guard($guard)->check());

    $home = $role ? config("navigation.$role.home", '/') : '/login';
    $homeLabel = $role ? 'Kembali ke dashboard' : 'Ke halaman masuk';
@endphp
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title>{{ $code }} · {{ $title }} · BISa</title>

    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/logo_bisa.png') }}">
    <link href="{{ asset('matrix/dist/css/style.min.css') }}" rel="stylesheet">
    <link href="{{ \App\Support\Asset::versioned('css/bisa.css') }}" rel="stylesheet">

    <style>
        .error {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: var(--bisa-space-5);
            background: var(--bisa-bg);
        }

        .error__card {
            width: 100%;
            max-width: 520px;
            text-align: center;
            background: var(--bisa-surface);
            border: 1px solid var(--bisa-border);
            border-radius: var(--bisa-radius-lg);
            box-shadow: var(--bisa-shadow);
            padding: var(--bisa-space-7) var(--bisa-space-6);
        }

        .error__code {
            font-size: clamp(3rem, 12vw, 5rem);
            font-weight: 800;
            line-height: 1;
            letter-spacing: -0.04em;
            color: var(--bisa-primary);
            margin: 0 0 var(--bisa-space-3);
            font-feature-settings: "tnum" 1;
        }

        .error__title { font-size: 1.375rem; margin: 0 0 var(--bisa-space-2); }

        .error__body {
            color: var(--bisa-text-muted);
            margin: 0 auto var(--bisa-space-5);
            max-width: 42ch;
        }

        .error__actions {
            display: flex;
            gap: var(--bisa-space-2);
            justify-content: center;
            flex-wrap: wrap;
        }
    </style>
</head>

<body>
    <main class="error">
        <div class="error__card">
            <img src="{{ asset('assets/images/logo_fix.png') }}" alt="BISa" style="height:34px;margin-bottom:24px">

            <p class="error__code">{{ $code }}</p>
            <h1 class="error__title">{{ $title }}</h1>
            <p class="error__body">{{ $body }}</p>

            <div class="error__actions">
                <a href="{{ url($home) }}" class="btn btn-primary">{{ $homeLabel }}</a>
                <button type="button" class="btn btn-secondary" onclick="history.back()">Kembali</button>
            </div>
        </div>
    </main>
</body>

</html>
