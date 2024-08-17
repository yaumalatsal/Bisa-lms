<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ranking;

class RankingController extends Controller
{
    public function index()
    {
        $rankings = Ranking::orderBy('score', 'desc')->get();
        return view('ranking.index', compact('rankings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'score' => 'required|integer|min:0',
        ]);

        Ranking::create($request->all());

        return redirect()->route('ranking.index')
                        ->with('success', 'Ranking data added successfully.');
    }
}

