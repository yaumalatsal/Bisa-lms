@extends('layouts.guest')

@section('auth-title', 'Login Mentor')

@section('content')
    <p class="auth__eyebrow">Mentor</p>
    <h1 class="auth__title">Masuk ke akun Anda</h1>
    <p class="auth__lead">Gunakan email yang terdaftar sebagai mentor pendamping.</p>

    <form action="{{ url('/mentor/signin') }}" method="post">
        @csrf
        <x-auth-field name="email" label="Email" type="email" autocomplete="username" />
        <x-auth-field name="password" label="Password" type="password" autocomplete="current-password" />

        <button class="btn btn-primary w-100" type="submit">Login</button>
    </form>

    <x-auth-switch :links="[
        'Siswa' => url('/login'),
        'Investor' => route('investor.login'),
        'Admin' => route('admin.login'),
    ]" />
@endsection
