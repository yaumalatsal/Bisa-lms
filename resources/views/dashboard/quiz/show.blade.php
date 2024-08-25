@extends('dashboard_template.index')

@section('title-page')
    Selamat Mengerjakan
@endsection

@section('content')
<div class="container">
    <div class="quiz-header mb-5 text-center">
        <h2 class="display-4">{{ $mapel->name }}</h2>
        <p class="lead">
            Durasi: 
            <span id="timer" class="text-danger">{{ $mapel->durasi }}:00</span> menit
        </p>
        <div class="timer-container">
            <div id="progress-bar" class="progress-bar"></div>
        </div>
    </div>
    
    <form id="quiz-form" action="{{ route('dashboard.quiz.submit', $mapel->id) }}" method="POST" onsubmit="return handleSubmit(event)">
        @csrf

        <div id="quiz-questions">
            @foreach($mapel->quizSoals->shuffle() as $index => $soal)
                <div class="question-card animate__animated animate__fadeIn mb-4 p-4" data-question-index="{{ $index }}" style="display: {{ $index === 0 ? 'block' : 'none' }};">
                    <h4 class="question-number">{{ $index + 1 }}. {{ $soal->question }}</h4>
                    
                    <div class="options mt-3">
                        @foreach(['option_a', 'option_b', 'option_c', 'option_d'] as $key)
                            <label class="option-label" style="background-color: {{ ['#ffebee', '#e8f5e9', '#e3f2fd', '#fffde7'][array_search($key, ['option_a', 'option_b', 'option_c', 'option_d'])] }};">
                                <input type="radio" name="question_{{ $soal->id }}" value="{{ $soal->$key }}" />
                                <span class="option-text">{{ strtoupper(substr($key, -1)) }}. {{ $soal->$key }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <div class="navigation-buttons mt-4 d-flex justify-content-between">
            <button type="button" id="prev-button" class="btn btn-nav" disabled>
                <i class="fas fa-chevron-left"></i> Sebelumnya
            </button>
            <button type="button" id="next-button" class="btn btn-nav">
                Selanjutnya <i class="fas fa-chevron-right"></i>
            </button>
            <button type="submit" id="submit-button" class="btn btn-submit" style="display: none;">
                Kirim Jawaban
            </button>
        </div>
    </form>
</div>

<!-- Include Animate.css for animations -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

<!-- Include Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<!-- Include SweetAlert2 for modern alerts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- Musik --}}
<div id="youtube-player" style="display: none;">
    <iframe id="player" width="1" height="1" src="https://www.youtube.com/embed/-AvLz4_Qc4g?autoplay=1&loop=1&playlist=-AvLz4_Qc4g" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
</div>

<script>
    let isFormSubmitted = false; // Variable to track form submission

    document.addEventListener('DOMContentLoaded', (event) => {
        // Timer functionality
        let duration = {{ $mapel->durasi }} * 60; // Convert minutes to seconds
        const timerElement = document.getElementById('timer');
        const progressBarElement = document.getElementById('progress-bar');
        const formElement = document.getElementById('quiz-form');
        const totalDuration = {{ $mapel->durasi }} * 60;

        function updateTimer() {
            let minutes = Math.floor(duration / 60);
            let seconds = duration % 60;
            timerElement.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

            // Update progress bar
            const progress = ((totalDuration - duration) / totalDuration) * 100;
            progressBarElement.style.width = `${progress}%`;

            if (duration <= 0) {
                clearInterval(timerInterval);
                // Disable beforeunload event when time is up
                window.removeEventListener('beforeunload', handleBeforeUnload);
                Swal.fire({
                    icon: 'info',
                    title: 'Waktu Habis',
                    text: 'Waktu Anda telah habis. Formulir akan dikirimkan secara otomatis.',
                    timer: 3000,
                    showConfirmButton: false
                }).then(() => {
                    formElement.submit();
                });
            }
            duration--;
        }

        const timerInterval = setInterval(updateTimer, 1000);

        // Navigation functionality
        const questions = document.querySelectorAll('#quiz-questions .question-card');
        let currentIndex = 0;

        function showQuestion(index) {
            questions.forEach((question, i) => {
                question.style.display = i === index ? 'block' : 'none';
                question.classList.toggle('animate__fadeIn', i === index);
            });
            document.getElementById('prev-button').disabled = index === 0;
            document.getElementById('next-button').disabled = index === questions.length - 1;
            document.getElementById('submit-button').style.display = index === questions.length - 1 ? 'inline-block' : 'none';
        }

        document.getElementById('prev-button').addEventListener('click', () => {
            if (currentIndex > 0) {
                currentIndex--;
                showQuestion(currentIndex);
            }
        });

        document.getElementById('next-button').addEventListener('click', () => {
            if (currentIndex < questions.length - 1) {
                currentIndex++;
                showQuestion(currentIndex);
            }
        });

        // Show the first question initially
        showQuestion(currentIndex);

        // Prevent losing data on page unload
        function handleBeforeUnload(event) {
            if (!isFormSubmitted) {
                event.preventDefault();
                event.returnValue = ''; // Required for most browsers
            }
        }
        window.addEventListener('beforeunload', handleBeforeUnload);
    });

    function handleSubmit(event) {
        event.preventDefault(); // Prevent default form submission

        Swal.fire({
            title: 'Konfirmasi Pengiriman',
            text: 'Apakah Anda yakin ingin mengirimkan jawaban Anda?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#007bff',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Kirim',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                isFormSubmitted = true; // Set the flag to true
                document.getElementById('quiz-form').submit(); // Submit the form
            }
        });

        return false; // Prevent form from submitting automatically
    }
</script>


<style>
    .quiz-header {
        text-align: center;
        margin-bottom: 2rem;
        font-family: 'Arial', sans-serif;
    }

    .timer-container {
        margin-top: 1rem;
        position: relative;
        height: 30px;
        background-color: #f3f3f3;
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-bar {
        height: 100%;
        background-color: #007bff;
        width: 0;
        transition: width 1s linear;
    }

    .question-card {
        border: 2px solid #007bff;
        border-radius: 12px;
        background-color: #ffffff;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        transition: box-shadow 0.3s, transform 0.3s;
        padding: 20px;
        display: none;
    }

    .question-card:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        transform: scale(1.03);
    }

    .question-number {
        font-size: 1.5rem;
        font-weight: bold;
        color: #007bff;
    }

    .options {
        margin-top: 1rem;
    }

    .option-label {
        display: flex;
        align-items: center;
        padding: 1rem;
        border-radius: 8px;
        border: 2px solid transparent;
        cursor: pointer;
        transition: background-color 0.3s, border-color 0.3s;
    }

    .option-label:hover {
        background-color: #e1e1e1;
    }

    .option-text {
        margin-left: 0.5rem;
    }

    .btn-nav {
        background-color: #007bff;
        color: #ffffff;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1rem;
        transition: background-color 0.3s;
    }

    .btn-nav:hover {
        background-color: #0056b3;
    }

    .btn-submit {
        background-color: #28a745;
        color: #ffffff;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1rem;
        transition: background-color 0.3s;
    }

    .btn-submit:hover {
        background-color: #218838;
    }
</style>
@endsection
