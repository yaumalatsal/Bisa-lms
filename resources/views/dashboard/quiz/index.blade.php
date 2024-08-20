@extends('dashboard_template.index')

@section('title-page')
    Pilih Mapel Quiz
@endsection

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="font-weight-bold">Daftar Kuis yang Tersedia</h2>
        <p class="text-muted">Pilih mata pelajaran di bawah untuk memulai kuis</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        @foreach($mapels as $mapel)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-body text-center">
                        <div class="icon-circle bg-primary text-white mb-4 mx-auto" style="width: 70px; height: 70px; display: flex; justify-content: center; align-items: center;">
                            <i class="fas fa-book" style="font-size: 2rem;"></i>
                        </div>
                        <h5 class="card-title font-weight-bold">{{ $mapel->name }}</h5>
                        <p class="card-text text-muted">Durasi: {{ $mapel->durasi }} menit</p>
                        <button class="btn btn-outline-primary btn-block font-weight-bold" onclick="startQuiz({{ $mapel->id }})">Mulai Kuis</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
    function startQuiz(mapelId) {
        if(confirm("Apakah Anda yakin ingin memulai kuis ini?")) {
            window.location.href = `/quiz/${mapelId}`;
        }
    }
</script>

<style>
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }
    .icon-circle {
        border-radius: 50%;
    }
    @media (max-width: 767px) {
        .col-md-4 {
            margin-bottom: 30px;
        }
    }
</style>
@endsection
