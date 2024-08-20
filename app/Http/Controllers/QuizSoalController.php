<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuizSoal;
use App\Models\MapelsQuiz;

class QuizSoalController extends Controller
{
    public function index(Request $request)
    {
        $mapelId = $request->query('mapel_id');
        $soals = QuizSoal::where('mapel_id', $mapelId)->get();
        $mapel = MapelsQuiz::findOrFail($mapelId);
        return view('admin.quiz_soals.index', compact('soals', 'mapel'));
    }

    public function create(Request $request)
    {
        $mapelId = $request->query('mapel_id');
        return view('quiz_soals.create', compact('mapelId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'mapel_id' => 'required|exists:mapels_quiz,id',
            'question' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'key' => 'required|string',
        ]);

        QuizSoal::create($validated);

        return redirect()->route('quiz_soals.index', ['mapel_id' => $request->mapel_id])->with('success', 'Soal berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $soal = QuizSoal::findOrFail($id);
        return view('quiz_soals.edit', compact('soal'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'mapel_id' => 'required|exists:mapels_quiz,id',
            'question' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'key' => 'required|string',
        ]);

        $soal = QuizSoal::findOrFail($id);
        $soal->update($validated);

        return redirect()->route('quiz_soals.index', ['mapel_id' => $validated['mapel_id']])->with('success', 'Soal berhasil diupdate!');
    }

    public function destroy($id)
    {
        $soal = QuizSoal::findOrFail($id);
        $mapelId = $soal->mapel_id;
        $soal->delete();

        return redirect()->route('quiz_soals.index', ['mapel_id' => $mapelId])->with('success', 'Soal berhasil dihapus!');
    }
}
