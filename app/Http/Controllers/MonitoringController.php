<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Monitoring;
use App\Models\Siswa;
use App\Models\MonthlyReport;
use Illuminate\Support\Facades\Storage;
use Session;
use DB;


class MonitoringController extends Controller
{
    public function index()
{
    $user_id = Session::get('id_siswa');

    // Ambil data siswa berdasarkan id_siswa
    $siswa = Siswa::find($user_id);

    // Ambil semua laporan bulanan yang telah disetujui dan sesuai dengan user_id
    $monthlyReports = MonthlyReport::where('user_id', $user_id)
        ->where('status', 'disetujui') // Hanya menampilkan laporan yang disetujui
        ->get();

    // Hitung total profit, total penjualan, total pemasukan, total pengeluaran
    $totalSales = $monthlyReports->sum('total_sales');
    $totalRevenue = $monthlyReports->sum('revenue');
    $totalSpending = $monthlyReports->sum('spending');
    $totalProfit = $monthlyReports->sum(function ($report) {
        return $report->revenue - $report->spending;
    });

    // Ambil data bulan sebelumnya yang telah disetujui
    $previousMonthReports = MonthlyReport::where('user_id', $user_id)
        ->where('status', 'disetujui') // Hanya menampilkan laporan yang disetujui
        ->whereMonth('report_date', '=', now()->subMonth()->month)
        ->whereYear('report_date', '=', now()->subMonth()->year)
        ->get();

    // Hitung total dari bulan sebelumnya
    $previousTotalSales = $previousMonthReports->sum('total_sales');
    $previousTotalRevenue = $previousMonthReports->sum('revenue');
    $previousTotalSpending = $previousMonthReports->sum('spending');
    $previousTotalProfit = $previousMonthReports->sum(function ($report) {
        return $report->revenue - $report->spending;
    });

    // Hitung persentase perubahan dibandingkan bulan sebelumnya
    $profitPercentageChange = 0;
    if ($previousTotalProfit != 0) {
        $profitPercentageChange = (($totalProfit - $previousTotalProfit) / abs($previousTotalProfit)) * 100;
    }

    $salesPercentageChange = 0;
    if ($previousTotalSales != 0) {
        $salesPercentageChange = (($totalSales - $previousTotalSales) / abs($previousTotalSales)) * 100;
    }

    $revenuePercentageChange = 0;
    if ($previousTotalRevenue != 0) {
        $revenuePercentageChange = ((($totalRevenue - $previousTotalRevenue)) / abs($previousTotalRevenue)) * 100;
    }

    $spendingPercentageChange = 0;
    if ($previousTotalSpending != 0) {
        $spendingPercentageChange = (($totalSpending - $previousTotalSpending) / abs($previousTotalSpending)) * 100;
    }

    // Ambil laporan tahunan
    $currentYearReports = MonthlyReport::where('user_id', $user_id)
    ->whereYear('report_date', now()->year)
    ->where('status', 'disetujui') // Tambahkan kondisi ini
    ->get();

// Ambil laporan untuk tahun sebelumnya yang sudah disetujui
$previousYearReports = MonthlyReport::where('user_id', $user_id)
    ->whereYear('report_date', now()->subYear()->year)
    ->where('status', 'disetujui') // Tambahkan kondisi ini
    ->get();

// Profit untuk tahun ini
$currentYearProfit = $currentYearReports->sum(function ($report) {
    return $report->revenue - $report->spending;
});

// Profit untuk tahun sebelumnya
$previousYearProfit = $previousYearReports->sum(function ($report) {
    return $report->revenue - $report->spending;
});

// Hitung persentase perubahan profit
$profitPercentage = 0;
if ($previousYearProfit != 0) {
    $profitPercentage = (($currentYearProfit - $previousYearProfit) / abs($previousYearProfit)) * 100;
}

$currentYear = now()->year;
    $previousYear = now()->subYear()->year;

    // Ambil jumlah produk untuk tahun ini dan tahun lalu
    $currentYearProducts = MonthlyReport::where('user_id', $user_id)
        ->whereYear('created_at', $currentYear)
        ->where('status', 'disetujui')
        ->get();
    
    $currentSell = $currentYearProducts->sum('total_sales');

    $previousYearProducts = MonthlyReport::where('user_id', $user_id)
        ->whereYear('created_at', $previousYear)
        ->count();

    // Hitung pertumbuhan tahun ini dibandingkan tahun lalu
    $growthPercentage = 0;
    if ($previousYearProducts != 0) {
        $growthPercentage = (($currentYearProducts - $previousYearProducts) / $previousYearProducts) * 100;
    }

// Hitung persentase perubahan profit

    return view('monitoring.index', compact(
        'siswa', 
        'currentSell', 
        'previousYearProducts', 
        'growthPercentage',
        'totalSales', 
        'totalRevenue', 
        'totalSpending', 
        'totalProfit', 
        'profitPercentageChange',
        'salesPercentageChange',
        'revenuePercentageChange',
        'spendingPercentageChange',
        'currentYearProfit',
        'previousYearProfit',
        'profitPercentage'
    ));
}





    public function store(Request $request)
    {
        $request->validate([
            'business_process' => 'required',
            'value' => 'required|numeric',
            'product' => 'required',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'date' => 'required|date',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx', // Validation for file upload
        ]);

        // Handle file upload
        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('uploads', 'public');
        }

        // Create new monitoring record
        Monitoring::create([
            'business_process' => $request->input('business_process'),
            'value' => $request->input('value'),
            'product' => $request->input('product'),
            'quantity' => $request->input('quantity'),
            'price' => $request->input('price'),
            'date' => $request->input('date'),
            'file_path' => $filePath,
        ]);

        return redirect()->route('monitoring.index')
                         ->with('success', 'Monitoring data added successfully.');
    }
}
