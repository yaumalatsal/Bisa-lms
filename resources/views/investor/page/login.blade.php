@extends('layouts.guest')

@section('auth-title', 'Login Investor')

@section('content')
    <p class="auth__eyebrow">Investor</p>
    <h1 class="auth__title">Masuk ke akun Anda</h1>
    <p class="auth__lead">Telusuri produk mahasiswa dan perkembangan bisnisnya.</p>

    <form action="{{ route('investor.login-process') }}" method="post">
        @csrf
        <x-auth-field name="email" label="Email" type="email" autocomplete="username" />
        <x-auth-field name="password" label="Password" type="password" autocomplete="current-password" />

        <button class="btn btn-primary w-100" type="submit">Login</button>
    </form>

    <a href="{{ route('investor.register') }}" class="btn btn-secondary w-100 mt-3">Daftar sebagai Investor</a>

    <x-auth-switch :links="[
        'Siswa' => url('/login'),
        'Mentor' => url('/mentor/login'),
        'Admin' => route('admin.login'),
    ]" />
@endsection
