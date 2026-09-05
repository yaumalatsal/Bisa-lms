<?php

namespace App\Services;

use App\Models\MonthlyReport;
use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * Statistik monitoring bisnis untuk satu produk.
 *
 * Perhitungan ini sebelumnya disalin tiga kali (siswa, investor, mentor) di
 * MonitoringController — sekitar 190 baris identik per salinan — dan setiap
 * salinan menjalankan ~30 query terpisah, 24 di antaranya hanya untuk mengisi
 * grafik 12 bulan. Sekarang seluruhnya dihitung dari tiga query agregat.
 *
 * Perbaikan perilaku yang ikut dibawa:
 *  - pembagian dengan nol saat penjualan tahun lalu kosong (dulu fatal error);
 *  - perbandingan Collection dengan integer pada `growthPercentage`;
 *  - Log::info pada setiap request.
 */
class MonitoringStatsService
{
    private const STATUS_APPROVED = MonthlyReport::STATUS_APPROVED;

    /**
     * @return array<string, mixed>|null null bila produk belum punya laporan disetujui.
     */
    public function forProduct($productId): ?array
    {
        $currentYear = Carbon::now()->year;
        $previousYear = Carbon::now()->subYear()->year;

        $monthlyReports = MonthlyReport::where('product_id', $productId)
            ->where('status', self::STATUS_APPROVED)
            ->orderBy('report_date')
            ->get();

        if ($monthlyReports->isEmpty()) {
            return null;
        }

        // Satu query agregat menggantikan 24 query per-bulan.
        $byMonth = $this->aggregateByMonth($productId, [$currentYear, $previousYear]);

        $totals = $this->totalsFrom($monthlyReports);
        $lastMonth = Carbon::now()->subMonth();
        $previous = $this->bucket($byMonth, $lastMonth->year, $lastMonth->month);

        $currentYearRows = $byMonth->where('year', $currentYear);
        $previousYearRows = $byMonth->where('year', $previousYear);

        $currentYearProfit = $currentYearRows->sum('revenue') - $currentYearRows->sum('spending');
        $previousYearProfit = $previousYearRows->sum('revenue') - $previousYearRows->sum('spending');

        $thisYearSales = (float) $currentYearRows->sum('total_sales');
        $lastYearSales = (float) $previousYearRows->sum('total_sales');

        return [
            'monthlyReports' => $monthlyReports,
            'currentYear' => $currentYear,
            'previousYear' => $previousYear,

            'totalSales' => $totals['sales'],
            'totalRevenue' => $totals['revenue'],
            'totalSpending' => $totals['spending'],
            'totalProfit' => $totals['profit'],

            'salesPercentageChange' => $this->percentChange($totals['sales'], $previous['total_sales']),
            'revenuePercentageChange' => $this->percentChange($totals['revenue'], $previous['revenue']),
            'spendingPercentageChange' => $this->percentChange($totals['spending'], $previous['spending']),
            'profitPercentageChange' => $this->percentChange(
                $totals['profit'],
                $previous['revenue'] - $previous['spending']
            ),

            'currentYearProfit' => $currentYearProfit,
            'previousYearProfit' => $previousYearProfit,
            'profitPercentage' => $this->percentChange($currentYearProfit, $previousYearProfit),

            'thisYearSales' => $thisYearSales,
            'lastYearSales' => $lastYearSales,
            'salesGrowth' => (int) $this->percentChange($thisYearSales, $lastYearSales),

            // Jumlah laporan disetujui, bukan koleksi — dulu dibandingkan
            // sebagai Collection sehingga memicu TypeError.
            'currentSell' => $currentYearRows->sum('total_sales'),
            'previousYearProducts' => (int) $previousYearRows->sum('reports'),
            'growthPercentage' => $this->percentChange(
                $currentYearRows->sum('reports'),
                $previousYearRows->sum('reports')
            ),

            'monthlySalesThisYear' => $this->series($byMonth, $currentYear, 'total_sales'),
            // Ditampilkan sebagai batang ke bawah pada grafik.
            'monthlySalesLastYear' => array_map(
                fn ($value) => -$value,
                $this->series($byMonth, $previousYear, 'total_sales')
            ),
            'monthlyProfitThisYear' => $this->profitSeries($byMonth, $currentYear),
        ];
    }

    /**
     * Payload untuk halaman kosong, agar view tidak perlu menebak variabel.
     *
     * @return array<string, mixed>
     */
    public function emptyPayload(string $message): array
    {
        return ['message' => $message, 'monthlyReports' => null];
    }

    /**
     * Ringkasan per bulan untuk tahun-tahun yang diminta, dalam satu query.
     */
    private function aggregateByMonth($productId, array $years): Collection
    {
        return MonthlyReport::query()
            ->selectRaw('YEAR(report_date) as year, MONTH(report_date) as month')
            ->selectRaw('SUM(total_sales) as total_sales, SUM(revenue) as revenue, SUM(spending) as spending, COUNT(*) as reports')
            ->where('product_id', $productId)
            ->where('status', self::STATUS_APPROVED)
            // Rentang tanggal, bukan YEAR(report_date), agar index report_date terpakai.
            ->whereBetween('report_date', [
                Carbon::create(min($years), 1, 1)->startOfDay(),
                Carbon::create(max($years), 12, 31)->endOfDay(),
            ])
            ->groupBy('year', 'month')
            ->get()
            ->map(fn ($row) => (object) [
                'year' => (int) $row->year,
                'month' => (int) $row->month,
                'total_sales' => (float) $row->total_sales,
                'revenue' => (float) $row->revenue,
                'spending' => (float) $row->spending,
                'reports' => (int) $row->reports,
            ]);
    }

    /**
     * @return array{sales: float, revenue: float, spending: float, profit: float}
     */
    private function totalsFrom(Collection $reports): array
    {
        $revenue = (float) $reports->sum('revenue');
        $spending = (float) $reports->sum('spending');

        return [
            'sales' => (float) $reports->sum('total_sales'),
            'revenue' => $revenue,
            'spending' => $spending,
            'profit' => $revenue - $spending,
        ];
    }

    /**
     * @return array{total_sales: float, revenue: float, spending: float, reports: int}
     */
    private function bucket(Collection $byMonth, int $year, int $month): array
    {
        $row = $byMonth->first(fn ($r) => $r->year === $year && $r->month === $month);

        return [
            'total_sales' => $row->total_sales ?? 0.0,
            'revenue' => $row->revenue ?? 0.0,
            'spending' => $row->spending ?? 0.0,
            'reports' => $row->reports ?? 0,
        ];
    }

    /**
     * Deret 12 bulan (Januari–Desember) untuk satu kolom.
     *
     * @return array<int, int>
     */
    private function series(Collection $byMonth, int $year, string $column): array
    {
        $rows = $byMonth->where('year', $year)->keyBy('month');

        return array_map(
            fn ($month) => (int) ($rows->get($month)->{$column} ?? 0),
            range(1, 12)
        );
    }

    /**
     * @return array<int, int>
     */
    private function profitSeries(Collection $byMonth, int $year): array
    {
        $rows = $byMonth->where('year', $year)->keyBy('month');

        return array_map(function ($month) use ($rows) {
            $row = $rows->get($month);

            return $row ? (int) ($row->revenue - $row->spending) : 0;
        }, range(1, 12));
    }

    /**
     * Persentase perubahan yang aman terhadap pembagi nol.
     */
    private function percentChange(float $current, float $previous): float
    {
        if ($previous == 0.0) {
            return 0.0;
        }

        return (($current - $previous) / abs($previous)) * 100;
    }
}
