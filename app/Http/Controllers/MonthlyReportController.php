<?php

namespace App\Http\Controllers;

use App\Models\MonthlyReport;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Siswa;
use Session;

class MonthlyReportController extends Controller
{
    public function index()
    {
        // Retrieve user_id from the session
        $user_id = Session::get('id_siswa');

        // Fetch reports for the logged-in user
        $reports = MonthlyReport::where('user_id', $user_id)->get();
        return view('dashboard.laporan.index', compact('reports'));
    }

    public function create()
    {
        $user_id = Session::get('id_siswa');
        $products = Product::where('id_ceo', $user_id)->get();
        return view('dashboard.laporan.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:product,id',
            'total_sales' => 'required|numeric',
            'report_date' => 'required|date',
            'revenue' => 'required|numeric',
            'spending' => 'required|numeric',
            'file' => 'required|mimes:pdf|max:2048', // Validasi file PDF
        ]);

        // Retrieve user_id from the session
        $user_id = Session::get('id_siswa');

        if (is_null($user_id)) {
            return redirect()->back()->withErrors(['user_id' => 'User ID tidak ditemukan di sesi.']);
        }

        $filePath = $request->file('file')->store('uploads', 'public');

// Proses penyimpanan laporan
        MonthlyReport::create([
            'product_id' => $request->product_id,
            'total_sales' => $request->total_sales,
            'revenue' => $request->revenue,
            'spending' => $request->spending,
            'report_date' => $request->report_date,
            'user_id' => $user_id,
            'file_path' => $filePath,
            'status' => 'pending', // Set status sebagai 'pending'
        ]);

        return redirect()->route('dashboard.laporan.index')->with('success', 'Laporan berhasil dibuat.');

      }

    public function edit($id)
    {
        $report = MonthlyReport::findOrFail($id);
        $products = Product::all();
        return view('dashboard.laporan.edit', compact('report', 'products'));
    }

    public function update(Request $request, $id)
{
    // Validasi data yang masuk
    $validated = $request->validate([
        'product_id' => 'required|exists:product,id',
        'total_sales' => 'required|integer',
        'revenue' => 'required|numeric',
        'spending' => 'required|numeric',
        'report_date' => 'required|date',
        'file' => 'nullable|mimes:pdf|max:2048', // Validasi file PDF jika ada
        
    ]);

    // Temukan laporan berdasarkan ID
    $report = MonthlyReport::findOrFail($id);

    // Perbarui data laporan
    $report->update([
        'product_id' => $validated['product_id'],
        'total_sales' => $validated['total_sales'],
        'revenue' => $validated['revenue'],
        'spending' => $validated['spending'],
        'report_date' => $validated['report_date'],
        
    ]);

    // Cek apakah ada file PDF yang diunggah
    if ($request->hasFile('file')) {
        // Hapus file PDF lama jika ada
        

        // Simpan file PDF baru
        $path = $request->file('file')->store('reports', 'public');
        $report->update([
            'file_path' => $path,
        ]);
    }

    // Redirect kembali ke halaman laporan dengan pesan sukses
    return redirect()->route('dashboard.laporan.index')
        ->with('success', 'Laporan bulanan berhasil diperbarui.');
}


    // Redirect to the reports index page with a success message

public function destroy($id)
{
    $report = MonthlyReport::findOrFail($id);
    $report->delete();

    return redirect()->route('dashboard.laporan.index')->with('success', 'Laporan Bulanan Berhasil di Hapus');
}
}
