@extends('dashboard_template.index')

@section('title-page')
    Hasil Kuis
@endsection

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0">Hasil Kuis: {{ $mapel->name }}</h2>
        </div>
        <div class="card-body">
            @if ($latestResult)
                <div class="alert alert-info">
                    <h4 class="alert-heading">Nilai Anda Sekarang</h4>
                    <p class="display-4">{{ $latestResult->nilai }}</p>
                </div>
            @else
                <div class="alert alert-warning">
                    <p>Belum ada hasil kuis untuk kuis ini.</p>
                </div>
            @endif

            @if ($highestResult && $highestResult->nilai != $latestResult->nilai)
                <div class="alert alert-success">
                    <h4 class="alert-heading">Nilai Tertinggi Anda</h4>
                    <p class="display-4">{{ $highestResult->nilai }}</p>
                </div>
            @endif

            <div class="d-flex justify-content-between align-items-center mt-4">
                <a href="{{ route('dashboard.quiz.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Beranda
                </a>
                <a href="{{ route('dashboard.quiz.show', ['mapel_id' => $mapel->id]) }}" class="btn btn-success">
                    <i class="fas fa-redo"></i> Kerjakan Lagi Kuis
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
