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
        $products = Product::all();
        $users = Siswa::all();
        return view('dashboard.laporan.create', compact('products', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:product,id',
            'total_sales' => 'required|numeric',
            'revenue' => 'required|numeric',
            'spending' => 'required|numeric',
            'report_date' => 'required|date',
        ]);

        // Retrieve user_id from the session
        $user_id = Session::get('id_siswa');

if (is_null($user_id)) {
    return redirect()->back()->withErrors(['user_id' => 'User ID tidak ditemukan di sesi.']);
}

// Proses penyimpanan laporan
MonthlyReport::create([
    'product_id' => $request->product_id,
    'total_sales' => $request->total_sales,
    'revenue' => $request->revenue,
    'spending' => $request->spending,
    'report_date' => $request->report_date,
    'user_id' => $user_id,
]);

return redirect()->route('dashboard.laporan.index')->with('success', 'Laporan berhasil dibuat.');

    }

    public function edit($id)
    {
        $user_id = Session::get('user_id');

        // Fetch the report for the logged-in user
        $report = MonthlyReport::where('id', $id)
            ->where('user_id', $user_id)
            ->firstOrFail();

        return view('dashboard.laporan.edit', compact('report'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'total_sales' => 'required|numeric',
            'revenue' => 'required|numeric',
            'spending' => 'required|numeric',
            'report_date' => 'required|date',
        ]);

        $user_id = Session::get('user_id');

        // Fetch the report for the logged-in user
        $report = MonthlyReport::where('id', $id)
            ->where('user_id', $user_id)
            ->firstOrFail();

        $report->update([
            'product_id' => $request->product_id,
            'total_sales' => $request->total_sales,
            'revenue' => $request->revenue,
            'spending' => $request->spending,
            'report_date' => $request->report_date,
        ]);

        return redirect()->route('dashboard.laporan.index')->with('success', 'Laporan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user_id = Session::get('user_id');

        // Fetch the report for the logged-in user
        $report = MonthlyReport::where('id', $id)
            ->where('user_id', $user_id)
            ->firstOrFail();

        $report->delete();

        return redirect()->route('dashboard.laporan.index')->with('success', 'Laporan berhasil dihapus.');
    }
}
