@extends('layouts.guest')

@section('auth-title', 'Pendaftaran Investor')

@section('content')
    <p class="auth__eyebrow">Investor</p>
    <h1 class="auth__title">Buat akun investor</h1>
    <p class="auth__lead">Setelah mendaftar Anda dapat langsung masuk.</p>

    <form action="{{ route('investor.register-process') }}" method="post">
        @csrf
        <x-auth-field name="nama" label="Nama Lengkap" autocomplete="name" />
        <x-auth-field name="email" label="Email" type="email" autocomplete="email" />
        <x-auth-field name="nomor_telepon" label="Nomor Telepon" type="tel" autocomplete="tel" />
        <x-auth-field name="password" label="Password" type="password" autocomplete="new-password" />
        <p class="text-muted" style="font-size:.8125rem;margin-top:-8px">Minimal 8 karakter.</p>

        <button type="submit" class="btn btn-primary w-100">Daftar Sekarang</button>
    </form>

    <a href="{{ route('investor.login') }}" class="btn btn-secondary w-100 mt-3">Sudah punya akun? Masuk</a>
@endsection
