<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FeedbackController extends Controller
{
    /**
     * Feedback yang ditulis mentor yang sedang login.
     */
    public function getFeedback()
    {
        // Dulu `->get()` tanpa select apa pun pada tiga tabel yang di-join,
        // sehingga kolom bernama sama (mis. `id`) saling menimpa.
        $feed = DB::table('feedback')
            ->select(
                'feedback.*',
                'feedback.id as id_feedback',
                'master_step.nama_step',
                'master_step.step_number',
                'product.nama_produk'
            )
            ->join('master_step', 'master_step.id', '=', 'feedback.id_step')
            ->join('product', 'product.id', '=', 'feedback.id_produk')
            ->where('feedback.id_mentor', Auth::guard('mentor')->id())
            ->latest('feedback.id')
            ->get();

        return view('mentor.page.feedback', [
            'feed' => $feed,
            'masterstep' => DB::table('master_step')->orderBy('step_number')->get(),
        ]);
    }

    /**
     * Feedback untuk produk tim siswa yang sedang login.
     */
    public function siswaFeedback(Request $request)
    {
        $feed = DB::table('feedback')
            ->select(
                'feedback.*',
                'feedback.id as id_feedback',
                'master_step.nama_step',
                'master_step.step_number',
                'product.nama_produk'
            )
            ->join('master_step', 'master_step.id', '=', 'feedback.id_step')
            ->join('product', 'product.id', '=', 'feedback.id_produk')
            ->where('feedback.id_produk', $request->session()->get('id_produk'))
            ->latest('feedback.id')
            ->get();

        return view('dashboard.feedback', compact('feed'));
    }

    /**
     * Tandai satu feedback sebagai sudah dibaca / dikonfirmasi.
     */
    public function konfirmFeed(Request $request)
    {
        $validated = $request->validate([
            'id_feed' => ['required', 'integer'],
        ]);

        // Dibatasi pada produk tim siswa ini; sebelumnya id mana pun bisa
        // dikonfirmasi oleh siswa mana pun.
        DB::table('feedback')
            ->where('id', $validated['id_feed'])
            ->where('id_produk', $request->session()->get('id_produk'))
            ->update(['status' => 1]);

        return redirect('/feedback')->with('success', 'Feedback dikonfirmasi.');
    }
}
