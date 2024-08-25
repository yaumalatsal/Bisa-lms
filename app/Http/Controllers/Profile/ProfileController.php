<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Penilaian;
use App\Models\QuizHasil;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    public function showProfile()
    {
        $siswa_id = Session::get('id_siswa');

        $siswa = Siswa::withSum('courseCompletions as total_course_score', 'score')
            ->withSum('courseAnswers as total_answer_score', 'score')
            ->with(['members.produk.penilaian' => function ($query) {
                $query->select('file_nilai');
            }])
            ->findOrFail($siswa_id);
        
        $produk_id = $siswa->members[0]->id_produk;

        $total_penilaian = Penilaian::where('id_produk', $produk_id)->sum('file_nilai');

        // Calculate total penilaian
        $quiz_hasil = QuizHasil::where('user_id', $siswa_id)->sum('nilai');

        // Calculate total quiz score
        $totalQuizScore = $siswa->quizHasil->sum('nilai');

        // Calculate total score
        $totalScore = $siswa->total_course_score
            + $siswa->total_answer_score
            + $total_penilaian
            + $totalQuizScore;

        $level = intval($totalScore / 100);



        return view('dashboard.profile.index', compact('siswa', 'totalScore', 'level'));
    }

    public function updateProfile(Request $request)
    {
        $siswa_id = Session::get('id_siswa');

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:siswa,email,' . $siswa_id,
            // Add other validation rules as needed
        ]);

        $siswa = Siswa::findOrFail($siswa_id);
        $siswa->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            // Update other fields as needed
        ]);

        return redirect()->route('siswa.profile')->with('success', 'Profile updated successfully!');
    }
}
