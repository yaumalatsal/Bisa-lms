<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MapelsQuiz;
use App\Models\QuizHasil;
use Session;

class QuizController extends Controller
{
    //
    public function index()
    {
        $mapels = MapelsQuiz::all(); // Mengambil semua mapel yang tersedia
        return view('dashboard.quiz.index', compact('mapels'));
    }

    public function showQuiz($mapel_id)
    {
        $mapel = MapelsQuiz::with('quizSoals')->findOrFail($mapel_id);
        return view('dashboard.quiz.show', compact('mapel'));
    }

    public function submitQuiz(Request $request, $mapel_id)
    {
        $mapel = MapelsQuiz::findOrFail($mapel_id);
        $questions = $mapel->quizSoals;

        $totalQuestions = $questions->count();
        $correctAnswers = 0;

        foreach ($questions as $question) {
            $answer = $request->input('question_'.$question->id);
            if ($answer == $question->key) {
                $correctAnswers++;
            }
        }

        // Hitung nilai maksimal 100
        $score = ($correctAnswers / $totalQuestions) * 100;

        $user_id = Session::get('id_siswa');

        // Cek apakah user sudah pernah mengerjakan kuis ini
        $existingResult = QuizHasil::where('user_id', $user_id)->where('mapel_id', $mapel_id)->first();

        if ($existingResult) {
            // Update nilai hanya jika nilai baru lebih tinggi dari nilai lama
            if ($score > $existingResult->nilai) {
                $existingResult->update(['nilai' => $score]);
            }
        } else {
            // Simpan hasil kuis baru
            QuizHasil::create([
                'user_id' => $user_id,
                'mapel_id' => $mapel_id,
                'nilai' => $score,
            ]);
        }

        return redirect()->route('dashboard.quiz.result', ['mapel_id' => $mapel_id])->with('success', 'Kuis telah selesai!');
    }

    public function showResult($mapel_id)
    {
        $mapel = MapelsQuiz::findOrFail($mapel_id);
        $user_id = Session::get('id_siswa');
        $result = QuizHasil::where('user_id', $user_id)->where('mapel_id', $mapel_id)->first();

        return view('dashboard.quiz.result', compact('mapel', 'result'));
    }

}