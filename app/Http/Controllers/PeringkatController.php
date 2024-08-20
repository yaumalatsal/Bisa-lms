<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuizHasil;
use App\Models\MapelsQuiz;

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
}
