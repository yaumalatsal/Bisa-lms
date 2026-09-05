@extends('layouts.guest')

@section('auth-title', 'Login Admin')

@section('content')
    <p class="auth__eyebrow">Admin</p>
    <h1 class="auth__title">Masuk ke panel admin</h1>
    <p class="auth__lead">Akses pengelolaan produk, siswa, materi dan soal.</p>

    <form action="{{ route('admin.login-process') }}" method="post">
        @csrf
        <x-auth-field name="email" label="Email" type="email" autocomplete="username" />
        <x-auth-field name="password" label="Password" type="password" autocomplete="current-password" />

        <button class="btn btn-primary w-100" type="submit">Login</button>
    </form>

    <x-auth-switch :links="[
        'Siswa' => url('/login'),
        'Mentor' => url('/mentor/login'),
        'Investor' => route('investor.login'),
    ]" />
@endsection
