<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TeamController extends Controller
{
    /**
     * Posisi CEO. Anggota lain memakai id posisi selain ini.
     */
    private const POSITION_CEO = 1;

    public function index(Request $request)
    {
        $idCeo = Auth::guard('siswa')->id();

        $getproduk = DB::table('product')->where('id_ceo', $idCeo)->get();
        $produk = optional($getproduk->last())->id ?? 0;

        $request->session()->put('id_produk', $produk);

        $getceo = DB::table('siswa')->where('id', $idCeo)->get();

        $position = DB::table('position')->where('id', '!=', self::POSITION_CEO)->get();

        $getmember = DB::table('member')
            ->join('siswa', 'siswa.id', '=', 'member.id_siswa')
            ->select('siswa.nama', 'siswa.nomor_induk', 'member.id', 'member.position', 'member.id_produk', 'member.id_siswa')
            ->where('member.position', '!=', self::POSITION_CEO)
            ->where('member.id_produk', $produk)
            ->get();

        return view('dashboard.tahap_team', [
            'getproduk' => $getproduk,
            'getceo' => $getceo,
            'getmember' => $getmember,
            'position' => $position,
            'countmember' => $getmember->count(),
        ]);
    }

    public function tambah_member(Request $request)
    {
        $validated = $request->validate([
            'id_siswa' => ['required', 'integer', 'exists:siswa,id'],
            'id_produk' => ['required', 'integer'],
            'position' => ['required', 'integer'],
        ]);

        if (! $this->ownsProduct($validated['id_produk'])) {
            return redirect('/tahap_team')->with('status', 'Anda bukan CEO dari produk ini.');
        }

        $sudahDiTim = DB::table('member')
            ->where('id_siswa', $validated['id_siswa'])
            ->where('id_produk', $validated['id_produk'])
            ->exists();

        if ($sudahDiTim) {
            return redirect('/tahap_team')
                ->with('status', 'Siswa dengan NIS tersebut sudah menjadi bagian tim anda');
        }

        $posisiTerisi = DB::table('member')
            ->where('position', $validated['position'])
            ->where('id_produk', $validated['id_produk'])
            ->exists();

        if ($posisiTerisi) {
            $namaPosisi = DB::table('position')->where('id', $validated['position'])->value('posisi')
                ?? ((int) $validated['position'] === 2 ? 'HIPSTER' : 'HACKER');

            return redirect('/tahap_team')
                ->with('status', 'Role ' . $namaPosisi . ' sudah ada di tim anda');
        }

        DB::table('member')->insert([
            'id_siswa' => $validated['id_siswa'],
            'id_produk' => $validated['id_produk'],
            'position' => $validated['position'],
        ]);

        return redirect('/tahap_team')->with('status', 'Member berhasil ditambahkan ke tim');
    }

    /**
     * Hanya CEO dari produk terkait yang boleh menghapus anggotanya, dan CEO
     * tidak dapat menghapus dirinya sendiri dari tim.
     */
    public function delete_member($id)
    {
        $member = DB::table('member')->where('id', $id)->first();

        if (! $member || ! $this->ownsProduct($member->id_produk)) {
            return redirect('/tahap_team')->with('status', 'Anda tidak berhak menghapus member ini.');
        }

        if ((int) $member->position === self::POSITION_CEO) {
            return redirect('/tahap_team')->with('status', 'CEO tidak dapat dihapus dari tim.');
        }

        DB::table('member')->where('id', $id)->delete();

        return redirect('/tahap_team')->with('status', 'Member berhasil dihapus dari tim');
    }

    public function lock_team(Request $request)
    {
        $validated = $request->validate([
            'id_produk' => ['required', 'integer'],
        ]);

        if (! $this->ownsProduct($validated['id_produk'])) {
            return redirect('/tahap_team')->with('status', 'Anda bukan CEO dari produk ini.');
        }

        DB::table('track_step')
            ->where('id_ceo', Auth::guard('siswa')->id())
            ->update([
                'id_produk' => $validated['id_produk'],
                'status' => 1,
            ]);

        $request->session()->put('track_status', 1);

        return redirect('/');
    }

    /**
     * Apakah siswa yang login adalah CEO dari produk ini?
     */
    private function ownsProduct($productId): bool
    {
        return DB::table('product')
            ->where('id', $productId)
            ->where('id_ceo', Auth::guard('siswa')->id())
            ->exists();
    }
}
