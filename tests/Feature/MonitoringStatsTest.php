<?php

namespace Tests\Feature;

use App\Models\MonthlyReport;
use App\Models\Siswa;
use App\Services\MonitoringStatsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class MonitoringStatsTest extends TestCase
{
    use RefreshDatabase;

    private MonitoringStatsService $stats;
    private int $siswaId;

    protected function setUp(): void
    {
        parent::setUp();
        $this->stats = app(MonitoringStatsService::class);

        // monthly_reports.user_id and product_id are real foreign keys.
        // Auto-increment ids are not reset between tests, so capture the id.
        $this->siswaId = Siswa::create(['nomor_induk' => '1', 'password' => 'x', 'tanggal_lahir' => '2000-01-01', 'nama' => 'Siswa'])->id;
        DB::table('mentor')->insert(['id' => 1, 'nama' => 'M', 'email' => 'm@t.local', 'password' => 'x', 'nomor_telepon' => '1', 'umur' => 30, 'instansi' => 'UM']);
        DB::table('product')->insert(['id' => 1, 'nama_produk' => 'P', 'deskripsi' => 'd', 'id_mentor' => 1, 'id_ceo' => $this->siswaId]);
    }

    /** @test */
    public function a_product_with_no_prior_year_sales_does_not_divide_by_zero(): void
    {
        // The old code computed (($thisYear - $lastYear) / $lastYear) with no
        // guard, so the very first year of trading threw DivisionByZeroError.
        $this->report(date('Y') . '-03-01', sales: 40, revenue: 4_000_000, spending: 1_000_000);

        $data = $this->stats->forProduct(1);

        $this->assertNotNull($data);
        $this->assertSame(0, $data['salesGrowth']);
        $this->assertSame(0.0, $data['profitPercentage']);
    }

    /** @test */
    public function it_returns_null_when_there_are_no_approved_reports(): void
    {
        $this->report(date('Y') . '-03-01', sales: 40, revenue: 100, spending: 10, status: MonthlyReport::STATUS_PENDING);

        $this->assertNull($this->stats->forProduct(1));
    }

    /** @test */
    public function only_approved_reports_are_counted(): void
    {
        $this->report(date('Y') . '-01-01', sales: 10, revenue: 1000, spending: 400);
        $this->report(date('Y') . '-02-01', sales: 99, revenue: 9999, spending: 1, status: MonthlyReport::STATUS_PENDING);

        $data = $this->stats->forProduct(1);

        $this->assertSame(10.0, $data['totalSales']);
        $this->assertSame(600.0, $data['totalProfit']);
    }

    /** @test */
    public function monthly_series_always_has_twelve_entries_in_calendar_order(): void
    {
        $this->report(date('Y') . '-03-01', sales: 5, revenue: 100, spending: 40);
        $this->report(date('Y') . '-11-01', sales: 7, revenue: 200, spending: 50);

        $data = $this->stats->forProduct(1);

        $this->assertCount(12, $data['monthlySalesThisYear']);
        $this->assertCount(12, $data['monthlySalesLastYear']);
        $this->assertCount(12, $data['monthlyProfitThisYear']);

        // March is index 2, November index 10.
        $this->assertSame(5, $data['monthlySalesThisYear'][2]);
        $this->assertSame(7, $data['monthlySalesThisYear'][10]);
        $this->assertSame(0, $data['monthlySalesThisYear'][0]);
        $this->assertSame(60, $data['monthlyProfitThisYear'][2]);
    }

    /** @test */
    public function prior_year_sales_are_negated_for_the_mirrored_chart(): void
    {
        $this->report((date('Y') - 1) . '-05-01', sales: 12, revenue: 100, spending: 10);
        $this->report(date('Y') . '-05-01', sales: 20, revenue: 300, spending: 10);

        $data = $this->stats->forProduct(1);

        $this->assertSame(-12, $data['monthlySalesLastYear'][4]);
        $this->assertSame(20, $data['monthlySalesThisYear'][4]);
    }

    /** @test */
    public function the_whole_summary_takes_a_handful_of_queries_not_dozens(): void
    {
        // One report per month, both years — the old implementation issued two
        // queries per month for the chart alone (24), plus ~10 more.
        foreach ([date('Y'), date('Y') - 1] as $year) {
            for ($month = 1; $month <= 12; $month++) {
                $this->report(sprintf('%d-%02d-10', $year, $month), sales: 5, revenue: 500, spending: 200);
            }
        }

        DB::enableQueryLog();
        $this->stats->forProduct(1);
        $queries = count(DB::getQueryLog());
        DB::disableQueryLog();

        $this->assertLessThanOrEqual(
            4,
            $queries,
            "Expected the summary to need a handful of queries, took $queries"
        );
    }

    private function report(
        string $date,
        int $sales,
        int $revenue,
        int $spending,
        string $status = MonthlyReport::STATUS_APPROVED
    ): void {
        DB::table('monthly_reports')->insert([
            'product_id' => 1,
            'user_id' => $this->siswaId,
            'total_sales' => $sales,
            'report_date' => $date,
            'revenue' => $revenue,
            'spending' => $spending,
            'status' => $status,
        ]);
    }
}
