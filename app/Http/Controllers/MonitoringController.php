<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Siswa;
use App\Services\MonitoringStatsService;
use Illuminate\Support\Facades\Auth;

class MonitoringController extends Controller
{
    public function __construct(private MonitoringStatsService $stats) {}

    /**
     * Monitoring bisnis untuk tim siswa yang sedang login.
     */
    public function index()
    {
        $idSiswa = Auth::guard('siswa')->id();
        $member = Member::where('id_siswa', $idSiswa)->first();

        if (! $member) {
            return view('monitoring.index', $this->stats->emptyPayload(
                'Belum terdaftar ke Member. Buat produk dulu atau bergabung ke sebuah tim.'
            ));
        }

        $data = $this->stats->forProduct($member->id_produk);

        if ($data === null) {
            return view('monitoring.index', $this->stats->emptyPayload(
                'Belum ada laporan bulanan yang disetujui untuk produk ini.'
            ));
        }

        return view('monitoring.index', $data + ['siswa' => Siswa::find($idSiswa)]);
    }

    /**
     * Monitoring satu produk, dilihat oleh investor.
     */
    public function investorMonitoring($product_id)
    {
        $data = $this->stats->forProduct($product_id);

        if ($data === null) {
            return view('investor.page.monitoring', $this->stats->emptyPayload(
                'Tim ini belum memiliki laporan bulanan yang disetujui.'
            ));
        }

        return view('investor.page.monitoring', $data);
    }

    /**
     * Monitoring satu produk, dilihat oleh mentor.
     */
    public function mentorMonitoring($product_id)
    {
        $data = $this->stats->forProduct($product_id);

        // Dulu cabang "kosong" di sini mengembalikan view milik investor.
        if ($data === null) {
            return view('mentor.pameran.monitoring', $this->stats->emptyPayload(
                'Tim ini belum memiliki laporan bulanan yang disetujui.'
            ));
        }

        return view('mentor.pameran.monitoring', $data);
    }
}
