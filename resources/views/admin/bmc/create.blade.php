@extends('admin/template/index')

@section('title-page', 'Tambah BMC')

@section('content')
<div class="container">
    <h1 class="mb-4">Tambah BMC</h1>

    <form action="{{ route('admin.bmc.store') }}" method="POST">
        @csrf

        <!-- Form Fields -->
        <div class="form-group">
            <label for="judul">Judul</label>
            <input type="text" class="form-control" id="judul" name="judul" placeholder="Masukkan Judul" required>
        </div>

        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" placeholder="Masukkan Deskripsi" required></textarea>
        </div>

        <div class="form-group">
            <label for="route">Route</label>
            <input type="text" class="form-control" id="route" name="route" placeholder="Masukkan Route" required>
        </div>

        <div class="form-group">
            <label for="icon">Icon</label>
            <input type="text" class="form-control" id="icon" name="icon" placeholder="Masukkan Icon" required>
        </div>

        <div class="form-group">
            <label for="video">Video</label>
            <input type="text" class="form-control" id="video" name="video" placeholder="Masukkan URL Video">
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.bmc.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
