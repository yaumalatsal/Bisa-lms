<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MonthlyReport;
use App\Models\Product;

class MonthlyReportController extends Controller
{
    public function index()
    {
        $reports = MonthlyReport::with('product')->get();
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
            'total_sales' => 'required|integer',
            'report_date' => 'required|date',
            'revenue' => 'required|numeric',
            'spending' => 'required|numeric',
        ]);

        MonthlyReport::create($request->all());
        return redirect()->route('dashboard.laporan.index')->with('success', 'Laporan Bulanan Berhasil di Buat');
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
