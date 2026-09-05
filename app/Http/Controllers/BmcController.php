<?php

namespace App\Http\Controllers;

use App\Services\ProductDetailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BmcController extends Controller
{
    public function __construct(private ProductDetailService $details) {}

    public function index()
    {
        return view('dashboard.bmc', [
            'bmc' => DB::table('master_bmc')->get(),
        ]);
    }

    /**
     * Daftar pertanyaan untuk satu poin BMC, digabung dengan jawaban tim ini
     * (bila ada).
     */
    public function detail(Request $request, $id)
    {
        $idProduk = $request->session()->get('id_produk');

        $databmc = DB::table('pertanyaan_bmc')
            ->select(
                'pertanyaan_bmc.*',
                'pertanyaan_bmc.id as id_pertanyaan_bmc',
                'jawaban_bmc.jawaban',
                'master_bmc.judul',
                'master_bmc.deskripsi',
                'master_bmc.icon'
            )
            // Dulu di-join lewat sub-select yang dirangkai dengan string; kini
            // kondisinya menjadi bagian dari JOIN dan nilainya di-bind.
            ->leftJoin('jawaban_bmc', function ($join) use ($idProduk) {
                $join->on('pertanyaan_bmc.id', '=', 'jawaban_bmc.id_pertanyaan')
                    ->where('jawaban_bmc.id_produk', '=', $idProduk);
            })
            ->join('master_bmc', 'master_bmc.id', '=', 'pertanyaan_bmc.id_poin_bmc')
            ->where('pertanyaan_bmc.id_poin_bmc', $id)
            ->get();

        return view('dashboard.bmc_detail', [
            'databmc' => $databmc,
            'getmasterbmc' => DB::table('master_bmc')->where('id', $id)->get(),
        ]);
    }

    /**
     * Simpan / perbarui satu jawaban BMC.
     *
     * Produk dan siswa diambil dari sesi login, bukan dari input form: form
     * sebelumnya mengirim keduanya sebagai hidden field, sehingga siswa mana pun
     * dapat menulis jawaban ke produk tim lain.
     */
    public function insertJawaban(Request $request)
    {
        $validated = $request->validate([
            'id_pertanyaan' => ['required', 'integer', 'exists:pertanyaan_bmc,id'],
            'jawaban' => ['nullable', 'string'],
        ]);

        $idSiswa = Auth::guard('siswa')->id();
        $idProduk = $request->session()->get('id_produk');

        if (! $idProduk || ! $this->isTeamMember($idSiswa, $idProduk)) {
            return redirect()->back()->with('status', 'Anda tidak tergabung dalam tim produk ini.');
        }

        DB::table('jawaban_bmc')->updateOrInsert(
            [
                'id_produk' => $idProduk,
                'id_pertanyaan' => $validated['id_pertanyaan'],
            ],
            [
                'jawaban' => $validated['jawaban'],
                'id_siswa' => $idSiswa,
            ]
        );

        return redirect()->back()->with('status', 'Jawaban tersimpan.');
    }

    /**
     * Tandai tahap BMC selesai untuk produk tim ini.
     */
    public function updateTrack(Request $request)
    {
        $idProduk = $request->session()->get('id_produk');

        if ($idProduk) {
            DB::table('track_step')
                ->where('id_produk', $idProduk)
                ->update(['id_step' => '3', 'status' => '1']);

            $request->session()->put(['track' => '3', 'track_status' => '1']);
        }

        return redirect('/');
    }

    public function resultBMC($id_bmc, $id_produk)
    {
        return view('mentor.page.detail_result_bmc', $this->details->bmcResult($id_bmc, $id_produk));
    }

    public function resultSiswaBMC($id_bmc, $id_produk)
    {
        return view('dashboard.detail_result_bmc', $this->details->bmcResult($id_bmc, $id_produk));
    }

    private function isTeamMember($idSiswa, $idProduk): bool
    {
        return DB::table('member')
            ->where('id_siswa', $idSiswa)
            ->where('id_produk', $idProduk)
            ->exists();
    }
}
