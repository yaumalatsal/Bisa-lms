@extends('dashboard_template.index')

@section('title-page')
    Selamat Mengerjakan
@endsection

@section('content')
<div class="container">
    <div class="quiz-header mb-5 text-center">
        <h2 class="display-4">{{ $mapel->name }}</h2>
        <p class="lead">Durasi: <span id="timer" class="text-danger">{{ $mapel->durasi }}:00</span> menit</p>
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
                // Submit the form if confirmed
                document.getElementById('quiz-form').submit();
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
        border: 2px solid #007bff;
        cursor: pointer;
        margin-bottom: 0.5rem;
        transition: background-color 0.3s, border-color 0.3s;
        position: relative;
        font-size: 1.1rem;
    }

    .option-label:hover {
        background-color: #007bff;
        color: #ffffff;
        border-color: #0056b3;
    }

    .option-label input[type="radio"] {
        position: absolute;
        opacity: 0;
    }

    .option-label input[type="radio"] + .option-text::before {
        content: ""; /* Remove default A. B. C. D. */
        display: inline-block;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 2px solid #007bff;
        margin-right: 10px;
        background-color: #ffffff;
        vertical-align: middle;
        transition: background-color 0.3s, border-color 0.3s;
    }

    .option-label input[type="radio"]:checked + .option-text::before {
        background-color: #007bff;
        border-color: #007bff;
    }

    .option-text {
        font-size: 1.1rem;
        display: inline-block;
        line-height: 20px;
    }

    .btn-nav {
        background-color: #28a745;
        border-color: #28a745;
        padding: 0.5rem 1.5rem;
        border-radius: 6px;
        font-size: 1rem;
        color: #ffffff;
        display: flex;
        align-items: center;
        transition: background-color 0.3s;
    }

    .btn-nav:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }

    .btn-submit {
        background-color: #007bff;
        border-color: #007bff;
        padding: 0.5rem 1.5rem;
        border-radius: 6px;
        font-size: 1rem;
        color: #ffffff;
        display: flex;
        align-items: center;
        transition: background-color 0.3s;
    }

    .btn-submit:hover {
        background-color: #0056b3;
        border-color: #004085;
    }

    .navigation-buttons {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1rem;
    }
</style>
@endsection
