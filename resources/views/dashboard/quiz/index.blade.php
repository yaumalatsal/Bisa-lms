@extends('dashboard_template.index')

@section('title-page')
    Pilih Mapel Quiz
@endsection

@section('content')
<div class="container py-5">
    <div class="text-center mb-5 drop-in">
        <h2 class="font-weight-bold text-cyan">Daftar Kuis yang Tersedia</h2>
        <p class="text-muted">Pilih mata pelajaran di bawah untuk memulai kuis</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success drop-in">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        @foreach($mapels as $mapel)
            <div class="col-md-4 mb-4 drop-in" style="animation-delay: {{ $loop->index * 0.5 }}s;">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body text-center">
                        <div class="text-white mb-4 mx-auto" style="width: 70px; height: 70px; display: flex; justify-content: center; align-items: center;">
                            <img src="{{ asset('assets/images/ilustration/gif/api.gif') }}" alt="Quiz Icon" style="width: 5rem; height: 5rem;"/>
                        </div>
                        <h5 class="card-title font-weight-bold">{{ $mapel->name }}</h5>
                        <p class="card-text text-muted">Durasi: {{ $mapel->durasi }} menit</p>
                        <button class="btn btn-outline-primary btn-block font-weight-bold rounded-pill" onclick="startQuiz({{ $mapel->id }})">Mulai Kuis</button>
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

    document.addEventListener("DOMContentLoaded", function() {
        const dropIns = document.querySelectorAll('.drop-in');

        dropIns.forEach((el, index) => {
            setTimeout(() => {
                el.classList.add('visible');
            }, index * 200);
        });

        // Particle.js effect for inferno theme
        particlesJS.load('particles-js', '{{ asset('assets/particles/inferno.json') }}', function() {
            console.log('Particles.js loaded with inferno theme.');
        });
    });
</script>

<style>
    #particles-js {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: -1;
    }

    .text-cyan {
        color: #00bcd4;
    }

    .card {
        border-radius: 20px;
        transition: transform 0.4s ease, box-shadow 0.4s ease;
    }

    .card:hover {
        transform: translateY(-10px) scale(1.05);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
    }

    .btn-outline-primary {
        border-color: #00bcd4;
        color: #00bcd4;
    }

    .btn-outline-primary:hover {
        background-color: #00bcd4;
        color: #fff;
    }

    /* Animations */
    .drop-in {
        opacity: 0;
        transform: translateY(-30px);
        transition: opacity 0.6s ease-out, transform 0.6s ease-out;
    }

    .drop-in.visible {
        opacity: 1;
        transform: translateY(0);
    }

    @media (max-width: 767px) {
        .col-md-4 {
            margin-bottom: 30px;
        }
    }
</style>

<div id="particles-js"></div>
@endsection
