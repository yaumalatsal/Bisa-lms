@extends('admin/template/index')

@section('content')
    <div class="container">
        <h1>Tambah Soal</h1>
        <form action="{{ route('admin.quiz_soals.store') }}" method="POST">
            @csrf
            <input type="hidden" name="mapel_id" value="{{ $mapelId }}">
            <div class="form-group">
                <label for="question">Soal</label>
                <textarea class="form-control" id="question" name="question" required></textarea>
            </div>
            <div class="form-group">
                <label for="option_a">Opsi A</label>
                <input type="text" class="form-control" id="option_a" name="option_a" required>
            </div>
            <div class="form-group">
                <label for="option_b">Opsi B</label>
                <input type="text" class="form-control" id="option_b" name="option_b" required>
            </div>
            <div class="form-group">
                <label for="option_c">Opsi C</label>
                <input type="text" class="form-control" id="option_c" name="option_c" required>
            </div>
            <div class="form-group">
                <label for="option_d">Opsi D</label>
                <input type="text" class="form-control" id="option_d" name="option_d" required>
            </div>
            <div class="form-group">
                <label for="key">Kunci Jawaban</label>
                <input type="text" class="form-control" id="key" name="key" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
@endsection