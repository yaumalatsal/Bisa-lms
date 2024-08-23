@extends('dashboard_template.index')

@section('title-page')
    Selamat
@endsection

@section('content')
<div class="container">
    <div class="quiz-header mb-4 text-center">
        <h2 class="display-4">{{ $mapel->name }}</h2>
        <p class="lead">Durasi: <span id="timer">{{ $mapel->durasi }}:00</span> menit</p>
    </div>
    
    <form id="quiz-form" action="{{ route('dashboard.quiz.submit', $mapel->id) }}" method="POST">
        @csrf

        <div id="quiz-questions">
            @foreach($mapel->quizSoals->shuffle() as $index => $soal)
                <div class="question-card animate__animated animate__fadeIn mb-4 p-4" data-question-index="{{ $index }}">
                    <h4 class="question-number">{{ $index + 1 }}.</h4>
                    <p class="question-text">{{ $soal->question }}</p>
                    <div class="options mt-2">
                        @foreach(['option_a', 'option_b', 'option_c', 'option_d'] as $key)
                            <label class="option-label">
                                <input type="radio" name="question_{{ $soal->id }}" value="{{ $soal->$key }}">
                                <span class="option-text">{{ strtoupper(substr($key, -1)) }}. {{ $soal->$key }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <div class="navigation-buttons mt-4 d-flex justify-content-between">
            <button type="button" id="prev-button" class="btn btn-secondary" disabled>Sebelumnya</button>
            <button type="button" id="next-button" class="btn btn-secondary">Selanjutnya</button>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>

<!-- Include Animate.css for animations -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

<!-- Include SweetAlert2 for modern alerts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        // Timer functionality
        let duration = {{ $mapel->durasi }} * 60; // Convert minutes to seconds
        const timerElement = document.getElementById('timer');
        const formElement = document.getElementById('quiz-form');

        function updateTimer() {
            let minutes = Math.floor(duration / 60);
            let seconds = duration % 60;
            timerElement.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
            if (duration <= 0) {
                clearInterval(timerInterval);
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
    });
</script>

<style>
    .quiz-header {
        text-align: center;
        margin-bottom: 2rem;
        font-family: 'Arial', sans-serif;
    }

    .question-card {
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #ffffff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.3s, transform 0.3s;
        padding: 20px;
        display: none;
    }

    .question-card:hover {
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        transform: scale(1.02);
    }

    .question-number {
        font-size: 1.5rem;
        font-weight: bold;
    }

    .question-text {
        font-size: 1.2rem;
        margin-top: 0.5rem;
        margin-bottom: 1rem;
    }

    .options {
        margin-top: 1rem;
    }

    .option-label {
        display: block;
        padding: 0.5rem;
        border-radius: 5px;
        transition: background-color 0.3s;
        cursor: pointer;
    }

    .option-label:hover {
        background-color: #f1f1f1;
    }

    .option-text {
        margin-left: 0.5rem;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        padding: 0.5rem 1rem;
        border-radius: 5px;
        font-size: 1rem;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
        padding: 0.5rem 1rem;
        border-radius: 5px;
        font-size: 1rem;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }

    .navigation-buttons {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1rem;
    }
</style>
@endsection
