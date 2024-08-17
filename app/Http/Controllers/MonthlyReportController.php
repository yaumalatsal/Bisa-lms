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
        return view('dashboard.laporan.create', compact('products'));
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
        $report = MonthlyReport::findOrFail($id);
        $products = Product::all();
        return view('dashboard.laporan.edit', compact('report', 'products'));
    }

    public function update(Request $request, $id)
{
    // Validate the request data
    $validated = $request->validate([
        'total_sales' => 'required|integer',
        'revenue' => 'required|numeric',
        'report_date' => 'required|date',
    ]);

    // Find the report by ID
    $report = MonthlyReport::findOrFail($id);

    // Update the report data
    $report->update([
        'total_sales' => $validated['total_sales'],
        'revenue' => $validated['revenue'],
        'report_date' => $validated['report_date'],
    ]);

    // Redirect to the reports index page with a success message
    return redirect()->route('dashboard.laporan.index')->with('success', 'Laporan Bulanan Berhasil di Edit.');
}
public function destroy($id)
{
    $report = MonthlyReport::findOrFail($id);
    $report->delete();

    return redirect()->route('dashboard.laporan.index')->with('success', 'Laporan Bulanan Berhasil di Hapus');
}
}
