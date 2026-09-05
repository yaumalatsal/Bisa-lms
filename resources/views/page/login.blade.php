@extends('layouts.guest')

@section('auth-title', 'Login Siswa')

@section('content')
    <p class="auth__eyebrow">Siswa</p>
    <h1 class="auth__title">Masuk ke akun Anda</h1>
    <p class="auth__lead">Gunakan Nomor Induk Siswa (NIS) dan password Anda.</p>

    <form action="{{ url('/signin') }}" method="post">
        @csrf
        <x-auth-field name="nis" label="Nomor Induk Siswa" type="number" autocomplete="username" />
        <x-auth-field name="password" label="Password" type="password" autocomplete="current-password" />

        <button class="btn btn-primary w-100" type="submit">Login</button>
    </form>

    <a href="{{ url('/register_siswa') }}" class="btn btn-secondary w-100 mt-3">Pendaftaran Siswa</a>

    <x-auth-switch :links="[
        'Mentor' => url('/mentor/login'),
        'Investor' => route('investor.login'),
        'Admin' => route('admin.login'),
    ]" />
@endsection
