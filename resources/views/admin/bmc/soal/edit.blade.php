@extends('admin/template/index')

@section('title-page', 'Edit Soal - ' . $bmc->judul)

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Soal - {{ $bmc->judul }}</h1>

    <form action="{{ route('admin.bmc.soal.update', [$bmc->id, $soal->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="pertanyaan" class="form-label">Pertanyaan</label>
            <input type="text" class="form-control" id="pertanyaan" name="pertanyaan" value="{{ $soal->pertanyaan }}" required>
        </div>

        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea class="form-control" id="keterangan" name="keterangan">{{ $soal->keterangan }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
