@extends('dashboard_template/index')

@section('title-page')
    Dashboard Siswa
@endsection

@section('css')
    <style>
        .container-fluid {
            background-color: #f0f3f5;
            padding: 2rem;
        }

        .alert {
            margin-bottom: 1rem;
        }

        .quiz-container {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin: 1rem 0;
        }

        .quiz-header {
            background-color: #00aaff;
            color: #ffffff;
            padding: 1rem;
            border-radius: 15px 15px 0 0;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .question-card {
            border: none;
            border-radius: 10px;
            margin-bottom: 1rem;
            padding: 1rem;
            background: #f9f9f9;
            transition: background-color 0.3s, transform 0.3s;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .question-card:hover {
            background-color: #e1eaff;
            transform: scale(1.02);
        }

        .question-card label {
            font-size: 1.2rem;
            font-weight: bold;
            display: block;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .question-card textarea {
            border: 1px solid #ddd;
            border-radius: 10px;
            width: 100%;
            padding: 0.75rem;
            box-sizing: border-box;
            transition: border-color 0.3s;
            resize: vertical;
        }

        .question-card textarea:focus {
            border-color: #00aaff;
            outline: none;
        }

        .submit-btn {
            background-color: #00aaff;
            color: #ffffff;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 20px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
            display: block;
            margin: 2rem auto;
        }

        .submit-btn:hover {
            background-color: #0088cc;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="quiz-container">
                <div class="quiz-header">
                    <h2>{{ $course->title }} - Questions</h2>
                </div>

                <form action="{{ route('siswa.courses.submitAnswers', $course->id) }}" id="quiz-form" method="POST">
                    @csrf
                    @foreach ($questions as $index => $question)
                        <div class="question-card">
                            <label for="question{{ $index }}">{{ $index + 1 }}.
                                {{ $question->question_text }}</label>
                            <textarea name="answers[{{ $question->id }}]" id="question{{ $index }}" rows="4"
                                placeholder="Type your answer here..."></textarea>
                        </div>
                    @endforeach
                    <button type="submit" class="submit-btn" onclick="confirmSubmit()">Submit Answers</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(function() {
            $("#table-one").DataTable();
        });

        function confirmSubmit() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to edit your answers once submitted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, submit it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('quiz-form').submit();
                }
            })
        }
    </script>
@endsection
