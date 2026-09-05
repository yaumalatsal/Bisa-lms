@extends('layouts.guest')

@section('auth-title', 'Pendaftaran Siswa')

@section('content')
    <p class="auth__eyebrow">Siswa</p>
    <h1 class="auth__title">Buat akun baru</h1>
    <p class="auth__lead">Isi data Anda sesuai data resmi kampus.</p>

    <form action="{{ url('/pendaftaran_siswa') }}" method="post">
        @csrf
        <x-auth-field name="nama_siswa" label="Nama Lengkap" autocomplete="name" />
        <x-auth-field name="nis" label="Nomor Induk Siswa" autocomplete="username" />
        <x-auth-field name="ttl" label="Tanggal Lahir" type="date" autocomplete="bday" />
        <x-auth-field name="password" label="Password" type="password" autocomplete="new-password" />
        <p class="text-muted" style="font-size:.8125rem;margin-top:-8px">Minimal 8 karakter.</p>

        <button type="submit" class="btn btn-primary w-100">Daftar Sekarang</button>
    </form>

    <a href="{{ url('/login') }}" class="btn btn-secondary w-100 mt-3">Sudah punya akun? Masuk</a>
@endsection
