<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuizHasil;
use App\Models\MapelsQuiz;
use App\Models\Siswa;

class PeringkatController extends Controller
{
    public function index()
    {
        $mapels = MapelsQuiz::all(); // Ambil semua mata pelajaran
        return view('dashboard.ranking.index', compact('mapels'));
    }

    public function getRankings($mapelId)
    {
        $rankings = QuizHasil::where('mapel_id', $mapelId)
            ->with('siswa')
            ->orderBy('nilai', 'desc')
            ->get();

        return response()->json($rankings);
    }

    public function showRankings()
    {
        $rankings = Siswa::withSum('courseCompletions as total_course_score', 'score')
            ->withSum('courseAnswers as total_answer_score', 'score')
            ->get()
            ->map(function ($siswa) {
                $siswa->total_score = $siswa->total_course_score + $siswa->total_answer_score;
                return $siswa;
            })->filter(function ($siswa) {
                return $siswa->total_score > 0;
            })
            ->sortByDesc('total_score');

        // dd($rankings);
        return view('dashboard.ranking.point-rank', compact('rankings'));
    }
}
