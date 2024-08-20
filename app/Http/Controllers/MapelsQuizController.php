<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MapelsQuiz;

class MapelsQuizController extends Controller
{
    public function index()
    {
        $mapels = MapelsQuiz::all();
        return view('admin.mapels.index', compact('mapels'));
    }

    public function create()
    {
        return view('admin.mapels.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'durasi' => 'required|integer|min:1',
        ]);

        MapelsQuiz::create($validated);

        return redirect()->route('admin.mapels.index')->with('success', 'Mapel berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $mapel = MapelsQuiz::findOrFail($id);
        return view('admin.mapels.edit', compact('mapel'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'durasi' => 'required|integer|min:1',
        ]);

        $mapel = MapelsQuiz::findOrFail($id);
        $mapel->update($validated);

        return redirect()->route('admin.mapels.index')->with('success', 'Mapel berhasil diupdate!');
    }

    public function destroy($id)
    {
        $mapel = MapelsQuiz::findOrFail($id);
        $mapel->delete();

        return redirect()->route('admin.mapels.index')->with('success', 'Mapel berhasil dihapus!');
    }
}
