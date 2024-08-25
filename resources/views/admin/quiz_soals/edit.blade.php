@extends('admin/template/index')

@section('content')
    <div class="container">
        <h1>Edit Soal</h1>
        <form action="{{ route('admin.quiz_soals.update', $soal->id) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="mapel_id" value="{{ $mapelId }}">
            <div class="form-group">
                <label for="question">Soal</label>
                <textarea class="form-control" id="question" name="question" required>{{ $soal->question }}</textarea>
            </div>
            <div class="form-group">
                <label for="option_a">Opsi A</label>
                <input type="text" class="form-control" id="option_a" name="option_a" value="{{ $soal->option_a }}" required>
            </div>
            <div class="form-group">
                <label for="option_b">Opsi B</label>
                <input type="text" class="form-control" id="option_b" name="option_b" value="{{ $soal->option_b }}" required>
            </div>
            <div class="form-group">
                <label for="option_c">Opsi C</label>
                <input type="text" class="form-control" id="option_c" name="option_c" value="{{ $soal->option_c }}" required>
            </div>
            <div class="form-group">
                <label for="option_d">Opsi D</label>
                <input type="text" class="form-control" id="option_d" name="option_d" value="{{ $soal->option_d }}" required>
            </div>
            <div class="form-group">
                <label for="key">Kunci Jawaban</label>
                <input type="text" class="form-control" id="key" name="key" value="{{ $soal->key }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
@endsection
