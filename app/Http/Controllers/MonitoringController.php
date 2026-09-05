<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Monitoring;
use App\Models\Product;
use App\Models\Siswa;
use App\Services\MonitoringStatsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MonitoringController extends Controller
{
    public function __construct(private MonitoringStatsService $stats)
    {
    }

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

    /**
     * Simpan satu catatan monitoring harian milik tim siswa yang login.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'business_process' => ['required', 'string', 'max:255'],
            'value' => ['required', 'numeric'],
            'product' => ['required', 'string', 'max:255'],
            'quantity' => ['required', 'integer', 'min:0'],
            'price' => ['required', 'numeric', 'min:0'],
            'date' => ['required', 'date'],
            'file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf,doc,docx', 'max:5120'],
        ]);

        if ($request->hasFile('file')) {
            $validated['file_path'] = $request->file('file')->store('uploads', 'public');
        }

        Monitoring::create($validated);

        return redirect()->route('monitoring.index')
            ->with('success', 'Data monitoring berhasil ditambahkan.');
    }
}
