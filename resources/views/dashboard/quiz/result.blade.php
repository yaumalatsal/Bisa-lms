@extends('dashboard_template.index')

@section('title-page')
    Hasil Quiz
@endsection

@section('content')
<div class="container">
    <h2>Hasil Kuis: {{ $mapel->name }}</h2>
    <p>Nilai Anda: {{ $result->nilai }}</p>
    <a href="{{ route('dashboard.quiz.index') }}" class="btn btn-primary">Kembali ke Beranda</a>
</div>
@endsection
