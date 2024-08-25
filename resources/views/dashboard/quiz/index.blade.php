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
                    <div class="card shadow-lg border-0 rounded-4">
                        <div class="card-body text-center">
                            <div class="icon-container mb-4 mx-auto">
                                <img src="{{ asset('assets/images/bukuk.gif') }}" alt="Quiz Icon" class="img-fluid"/>
                            </div>
                            <h5 class="card-title font-weight-bold">{{ $mapel->name }}</h5>
                            <p class="card-text text-muted">Durasi: {{ $mapel->durasi }} menit</p>
                            <button class="btn btn-primary btn-block font-weight-bold rounded-pill" onclick="startQuiz({{ $mapel->id }})">
                                <i class="fas fa-play"></i> Mulai Kuis
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <script>
        function startQuiz(mapelId) {
            Swal.fire({
                title: 'Mulai Kuis?',
                text: "Apakah Anda yakin ingin memulai kuis ini?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#00bcd4',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, mulai!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `/quiz/${mapelId}`;
                }
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            const dropIns = document.querySelectorAll('.drop-in');

            dropIns.forEach((el, index) => {
                setTimeout(() => {
                    el.classList.add('visible');
                }, index * 200);
            });

            // Particle.js effect
            particlesJS('particles-js', {
                "particles": {
                    "number": {
                        "value": 80,
                        "density": {
                            "enable": true,
                            "value_area": 800
                        }
                    },
                    "color": {
                        "value": "#ffffff"
                    },
                    "shape": {
                        "type": "circle",
                        "stroke": {
                            "width": 0,
                            "color": "#000000"
                        }
                    },
                    "opacity": {
                        "value": 0.5,
                        "random": false,
                        "anim": {
                            "enable": false,
                            "speed": 1,
                            "opacity_min": 0.1,
                            "sync": false
                        }
                    },
                    "size": {
                        "value": 3,
                        "random": true,
                        "anim": {
                            "enable": false,
                            "speed": 40,
                            "size_min": 0.1,
                            "sync": false
                        }
                    },
                    "line_linked": {
                        "enable": true,
                        "distance": 150,
                        "color": "#ffffff",
                        "opacity": 0.4,
                        "width": 1
                    },
                    "move": {
                        "enable": true,
                        "speed": 6,
                        "direction": "none",
                        "random": false,
                        "straight": false,
                        "out_mode": "out",
                        "bounce": false,
                        "attract": {
                            "enable": false,
                            "rotateX": 600,
                            "rotateY": 1200
                        }
                    }
                },
                "interactivity": {
                    "detect_on": "canvas",
                    "events": {
                        "onhover": {
                            "enable": true,
                            "mode": "repulse"
                        },
                        "onclick": {
                            "enable": true,
                            "mode": "push"
                        },
                        "resize": true
                    }
                },
                "retina_detect": true
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
            overflow: hidden;
            transition: transform 0.4s ease, box-shadow 0.4s ease;
            background-color: #ffffff;
        }

        .card-body {
            padding: 2rem;
        }

        .card:hover {
            transform: translateY(-10px) scale(1.05);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        .btn-primary {
            background-color: #00bcd4;
            border-color: #00bcd4;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #0097a7;
            border-color: #0097a7;
        }

        .icon-container img {
            width: 80px;
            height: 80px;
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
