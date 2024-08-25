@extends('dashboard_template.index')

@section('title-page')
    Point Rankings
@endsection

@section('css')
<style>
    /* General Container */
    .container-fluid {
        animation: fadeIn 1s ease-in;
    }

    /* Ranking Card Animation */
    .ranking-card {
        background-color: #f8f9fa;
        border-left: 5px solid #007bff;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 10px;
        animation: slideIn 1s ease-out;
        position: relative; /* To position the level progress bar */
        overflow: hidden;
    }

    .ranking-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.3);
    }

    /* Ranking Number Styles */
    .ranking-number {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: #fff;
        font-weight: bold;
        animation: bounce 1s infinite;
    }

    /* Gold, Silver, Bronze Effects */
    .ranking-card.gold .ranking-number {
        background: radial-gradient(circle, #ffd700 50%, #e5a400 100%);
        border: 2px solid #d4af37;
    }

    .ranking-card.silver .ranking-number {
        background: radial-gradient(circle, #c0c0c0 50%, #a0a0a0 100%);
        border: 2px solid #a8a8a8;
    }

    .ranking-card.bronze .ranking-number {
        background: radial-gradient(circle, #cd7f32 50%, #b66e41 100%);
        border: 2px solid #a45b35;
    }

    /* Blue for Rank 4 and Below */
    .ranking-card.blue .ranking-number {
        background: #007bff;
        border: 2px solid #0056b3;
    }

    /* Student Info Animation */
    .student-info h4, .student-info p {
        transition: color 0.3s ease;
    }

    .ranking-card:hover .student-info h4 {
        color: #007bff;
    }

    .ranking-card:hover .student-info p {
        color: #343a40;
    }

    /* Level and Progress Bar Styles */
    .student-info .level-container {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .student-info .progress-bar-container {
        width: 100%;
        height: 20px;
        background-color: #e9ecef;
        border-radius: 5px;
        margin-top: 10px;
        position: relative;
    }

    .student-info .progress-bar {
        height: 100%;
        background-color: #28a745;
        width: 0; /* Set dynamically via inline style */
        border-radius: 5px;
        transition: width 0.3s ease, background-color 0.3s ease;
        position: absolute;
        top: 0;
        left: 0;
        text-align: center;
        color: #fff;
        line-height: 20px;
        font-size: 12px;
        font-weight: bold;
    }

    .student-info .progress-text {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
    }

    /* Animated Progress Bar */
    @keyframes pulse {
        0% { background-color: #28a745; }
        50% { background-color: #ff5733; }
        100% { background-color: #28a745; }
    }

    .progress-bar.animated {
        animation: pulse 1.5s infinite;
    }

    /* Fade-In Animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    /* Slide-In Animation for Card */
    @keyframes slideIn {
        from {
            transform: translateY(20px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    /* Bounce Animation for Ranking Number */
    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {
            transform: translateY(0);
        }
        40% {
            transform: translateY(-10px);
        }
        60% {
            transform: translateY(-5px);
        }
    }

    /* Confetti Animation */
    @keyframes confetti {
        0% {
            transform: translateY(-100%) rotate(0deg);
            opacity: 1;
        }
        100% {
            transform: translateY(100%) rotate(360deg);
            opacity: 0;
        }
    }

    .confetti {
        position: absolute;
        top: 0;
        left: 0;
        width: 10px;
        height: 10px;
        background-color: #ff5722;
        opacity: 0;
        animation: confetti 3s infinite;
    }

    .confetti:nth-child(2) {
        background-color: #ffeb3b;
        animation-delay: 0.5s;
    }

    .confetti:nth-child(3) {
        background-color: #4caf50;
        animation-delay: 1s;
    }

    .confetti:nth-child(4) {
        background-color: #2196f3;
        animation-delay: 1.5s;
    }

    .celebration-gif {
    width: 50px; /* Adjust size as needed */
    height: 50px;
    margin-bottom: 10px;
    display: inline-block;
    vertical-align: middle;
}

</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="container">
            <h1 class="mb-4 text-center">Point Rankings</h1>
            
            <!-- Congratulations Message for Top 1 -->
            @if ($rankings->isNotEmpty())
                @php
                    $topRanking = $rankings->first();
                @endphp
                <div class="text-center mb-4 position-relative">
                    <img src="{{ asset ('assets/images/ilustration/gif/api.gif') }}" class="celebration-gif" alt="Left Celebration GIF">

                    <!-- Congratulations Message -->
                    <h2 class="text-success d-inline-block mx-2">Selamat {{ $topRanking['siswa']->nama }}!</h2>
                
                    <!-- Right GIF -->
                    <img src="{{ asset ('assets/images/ilustration/gif/api.gif') }}" class="celebration-gif" alt="Right Celebration GIF">
                    <p class="lead">Telah Menjadi Top Leaderboard!</p>
                    <div class="position-absolute top-50 start-50 translate-middle">
                        <!-- Confetti Animation -->
                        <div class="confetti"></div>
                        <div class="confetti"></div>
                        <div class="confetti"></div>
                        <div class="confetti"></div>
                    </div>
                </div>
            @endif
            
            <div class="row justify-content-center">
                @php
                    $index = 1;
                @endphp
                @foreach ($rankings as $ranking)
                    @php
                        $score = $ranking['total_score'];
                        $level = intdiv($score, 100); // Calculate level based on score
                        $nextLevelScore = ($level + 1) * 100;
                        $scoreNeeded = $nextLevelScore - $score;
                        $progress = ($score % 100); // Progress within the current level
                        $progressPercentage = ($progress / 100) * 100; // Convert progress to percentage

                        $cardClass = '';
                        if ($index == 1) $cardClass = 'gold';
                        elseif ($index == 2) $cardClass = 'silver';
                        elseif ($index == 3) $cardClass = 'bronze';
                        else $cardClass = 'blue';
                    @endphp
                    <div class="col-md-8 mb-4">
                        <div class="ranking-card p-3 rounded shadow-sm d-flex align-items-center {{ $cardClass }}">
                            <div class="ranking-number rounded-circle d-flex align-items-center justify-content-center">
                                <h2 class="mb-0">{{ $index }}</h2>
                                @php
                                    $index++
                                @endphp
                            </div>
                            <div class="student-info ms-4">
                                <h4 class="mb-1">{{ $ranking['siswa']->nama }}</h4>
                                <p class="mb-0">Course Score: <strong>{{ $ranking['totalCourseScore'] ?? 0 }}</strong></p>
                                <p class="mb-0">Answer Score: <strong>{{ $ranking['totalAnswerScore'] ?? 0 }}</strong></p>
                                <p class="mb-0">Product Score: <strong>{{ $ranking['totalPenilaian'] ?? 0}}</strong></p>
                                <p class="mb-0">Quiz Score: <strong>{{ $ranking['totalQuizScore'] ?? 0}}</strong></p>
                                <p class="mb-0">Total Score: <strong>{{ $ranking['total_score'] }}</strong></p>
                                <div class="level-container">
                                    <p class="mb-0">Level: <strong>{{ $level }}</strong></p>
                                    <div class="progress-bar-container">
                                        <div class="progress-bar animated" style="width: {{ $progressPercentage }}%;">
                                            <span class="progress-text">{{ $progress }}/100</span>
                                        </div>
                                    </div>
                                    <p class="mt-2">Score yang dibutuhkan untuk naik Level: <strong>{{ $scoreNeeded }} Score</strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(function() {
        $("#table-one").DataTable();
    });

    function confirmDeleteQuestion(id) {
        Swal.fire({
            title: 'Apa Yakin Menghapus Pertanyaan?',
            text: "Anda Tidak bisa mengulangi lagi!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>
@endsection
