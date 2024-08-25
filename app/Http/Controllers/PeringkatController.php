<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuizHasil;
use App\Models\MapelsQuiz;
use App\Models\Siswa;
use Illuminate\Support\Facades\DB;

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
        $rankings = Siswa::with(['members.produk.penilaian'])
        ->get()
        ->map(function ($siswa) {
            $totalCourseScore = $siswa->courseCompletions->sum('score');
            $totalAnswerScore = $siswa->courseAnswers->sum('score');
            
            // Aggregate penilaian scores
            $totalPenilaian = $siswa->members->reduce(function ($carry, $member) {
                // Ensure that $member->produk and $member->produk->penilaian are not null
                $penilaianTotal = $member->produk && $member->produk->penilaian
                    ? $member->produk->penilaian->sum('file_nilai')
                    : 0;

                return $carry + $penilaianTotal;
            }, 0);
            
            $totalScore = $totalCourseScore + $totalAnswerScore + $totalPenilaian;
            
            return [
                'siswa' => $siswa,
                'totalCourseScore' => $totalCourseScore,
                'totalAnswerScore' => $totalAnswerScore,
                'totalPenilaian' => $totalPenilaian,
                'total_score' => $totalScore
            ];
        })
        ->filter(function ($item) {
            return $item['total_score'] > 0;
        })
        ->sortByDesc('total_score');


        // dd($rankings);
        return view('dashboard.ranking.point-rank', compact('rankings'));
    }
}
