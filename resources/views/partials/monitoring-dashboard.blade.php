{{--
    Monitoring bisnis — satu implementasi untuk siswa, mentor dan investor.

    Sebelumnya ada tiga berkas ~690 baris yang identik, dan masing-masing
    menyisipkan dokumen HTML lengkap (doctype, <head>, <body> dan satu set UI kit
    kedua: Bootstrap, jQuery, popper, perfect-scrollbar) ke dalam area konten
    layout. Halaman jadi memuat dua <body>, dua jQuery dan dua Bootstrap.

    Sekarang: fragmen konten biasa, hanya ApexCharts yang ditambahkan.

    Variabel disediakan oleh App\Services\MonitoringStatsService.
--}}

@php
    /** Ubah persentase menjadi kelas + ikon arah. */
    $delta = function ($value) {
        if ($value > 0) {
            return ['bisa-stat__delta--up', 'mdi-arrow-up', '+' . number_format($value, 1) . '%'];
        }
        if ($value < 0) {
            return ['bisa-stat__delta--down', 'mdi-arrow-down', number_format($value, 1) . '%'];
        }
        return ['bisa-stat__delta--flat', 'mdi-minus', 'Tidak ada perubahan'];
    };

    $rupiah = fn ($value) => 'Rp ' . number_format((float) $value, 0, ',', '.');

    $stats = [
        ['Total Profit', $rupiah($totalProfit), $profitPercentageChange, 'mdi-cash-multiple'],
        ['Total Penjualan', number_format((float) $totalSales, 0, ',', '.') . ' produk', $salesPercentageChange, 'mdi-cart-outline'],
        ['Total Pemasukan', $rupiah($totalRevenue), $revenuePercentageChange, 'mdi-trending-up'],
        ['Total Pengeluaran', $rupiah($totalSpending), $spendingPercentageChange, 'mdi-trending-down'],
    ];
@endphp

<div class="bisa-stat-grid">
    @foreach ($stats as [$label, $value, $change, $icon])
        @php([$deltaClass, $deltaIcon, $deltaText] = $delta($change))
        <article class="bisa-stat">
            <span class="bisa-stat__label">
                <span class="bisa-stat__icon"><i class="mdi {{ $icon }}" aria-hidden="true"></i></span>
                {{ $label }}
            </span>
            <span class="bisa-stat__value">{{ $value }}</span>
            <span class="bisa-stat__delta {{ $deltaClass }}">
                <i class="mdi {{ $deltaIcon }}" aria-hidden="true"></i>
                {{ $deltaText }}
                <span class="bisa-muted fw-normal">vs bulan lalu</span>
            </span>
        </article>
    @endforeach
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <div>
                    <h2 class="card-title">Perkembangan Penjualan</h2>
                    <p class="card-subtitle">Perbandingan {{ $currentYear }} dengan {{ $previousYear }}</p>
                </div>
            </div>
            <div class="card-body">
                <div id="bisaSalesChart" style="min-height:320px"></div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Pertumbuhan Penjualan</h2>
            </div>
            {{-- A single percentage is a hero number, not a chart. The radial
                 gauge that used to sit here was clamped to +/-100, so once growth
                 passed 100% the ring was permanently full and carried no
                 information — while printing a number that disagreed with the
                 one beneath it. --}}
            <div class="card-body">
                @php([$growthClass, $growthIcon] = $delta($salesGrowth))
                <p class="bisa-hero-number {{ $growthClass }}">
                    <i class="mdi {{ $growthIcon }}" aria-hidden="true"></i>{{ number_format($salesGrowth) }}%
                </p>
                <p class="text-muted mb-0">
                    Dibanding tahun lalu, dari
                    <strong class="bisa-numeric">{{ number_format((float) $lastYearSales, 0, ',', '.') }}</strong>
                    menjadi
                    <strong class="bisa-numeric">{{ number_format((float) $thisYearSales, 0, ',', '.') }}</strong>
                    produk terjual.
                </p>

                {{-- The same figure as a proportion, capped so a very large
                     growth still draws a sensible bar. --}}
                <div class="bisa-meter" role="img"
                    aria-label="Pertumbuhan penjualan {{ number_format($salesGrowth) }} persen dibanding tahun lalu">
                    <span class="bisa-meter__fill" style="width: {{ max(0, min(100, abs($salesGrowth))) }}%"></span>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Profit Tahunan</h2>
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-7 fw-normal text-muted">{{ $currentYear }}</dt>
                    <dd class="col-5 text-end bisa-numeric fw-semibold">{{ $rupiah($currentYearProfit) }}</dd>
                    <dt class="col-7 fw-normal text-muted">{{ $previousYear }}</dt>
                    <dd class="col-5 text-end bisa-numeric fw-semibold">{{ $rupiah($previousYearProfit) }}</dd>
                    <dt class="col-7 fw-normal text-muted">Perubahan</dt>
                    <dd class="col-5 text-end fw-semibold">
                        @php([$pClass, $pIcon, $pText] = $delta($profitPercentage))
                        <span class="bisa-stat__delta {{ $pClass }}">
                            <i class="mdi {{ $pIcon }}" aria-hidden="true"></i>{{ $pText }}
                        </span>
                    </dd>
                </dl>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div>
            <h2 class="card-title">Laporan Bulanan Disetujui</h2>
            <p class="card-subtitle">{{ $monthlyReports->count() }} laporan</p>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Periode</th>
                    <th scope="col" class="text-end">Penjualan</th>
                    <th scope="col" class="text-end">Pemasukan</th>
                    <th scope="col" class="text-end">Pengeluaran</th>
                    <th scope="col" class="text-end">Profit</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($monthlyReports as $report)
                    @php($profit = $report->revenue - $report->spending)
                    <tr>
                        <th scope="row" class="fw-semibold">
                            {{ \Carbon\Carbon::parse($report->report_date)->translatedFormat('F Y') }}
                        </th>
                        <td class="text-end bisa-numeric">{{ number_format((float) $report->total_sales, 0, ',', '.') }}</td>
                        <td class="text-end bisa-numeric">{{ $rupiah($report->revenue) }}</td>
                        <td class="text-end bisa-numeric">{{ $rupiah($report->spending) }}</td>
                        <td class="text-end bisa-numeric">
                            @php([$rClass, $rIcon] = [$profit >= 0 ? 'bisa-stat__delta--up' : 'bisa-stat__delta--down', $profit >= 0 ? 'mdi-arrow-up' : 'mdi-arrow-down'])
                            <span class="bisa-stat__delta {{ $rClass }}">
                                <i class="mdi {{ $rIcon }}" aria-hidden="true"></i>{{ $rupiah(abs($profit)) }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
    {{-- Hanya ApexCharts. Tumpukan tema kedua (jQuery, popper, perfect-scrollbar,
         menu.js, main.js) dan skrip pihak ketiga buttons.github.io yang ikut
         terbawa dari demo tema sudah tidak dimuat lagi. --}}
    <script src="{{ asset('js/vendor/apexcharts.js') }}"></script>
    <script>
        (function () {
            if (typeof ApexCharts === 'undefined') {
                return;
            }

            var styles = getComputedStyle(document.documentElement);
            var token = function (name, fallback) {
                return (styles.getPropertyValue(name) || fallback).trim();
            };

            var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            var animate = { enabled: !reduceMotion, speed: 400 };

            var months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            var thisYear = @json(array_values($monthlySalesThisYear));
            // Disimpan sebagai nilai negatif agar tergambar ke bawah sumbu.
            var lastYear = @json(array_values($monthlySalesLastYear));

            new ApexCharts(document.querySelector('#bisaSalesChart'), {
                chart: { type: 'bar', height: 320, stacked: true, toolbar: { show: false }, fontFamily: 'inherit', animations: animate },
                series: [
                    { name: '{{ $currentYear }}', data: thisYear },
                    { name: '{{ $previousYear }}', data: lastYear }
                ],
                // One measure across two periods: a sequential emphasis pair from
                // the brand ramp, re-stepped per theme so both marks clear 3:1
                // against their surface. The table below carries the values.
                colors: [token('--bisa-chart-current', '#c2410c'), token('--bisa-chart-previous', '#f59e0b')],
                plotOptions: { bar: { borderRadius: 4, borderRadiusApplication: 'end', columnWidth: '52%' } },
                // A 2px surface gap keeps adjacent bars from fusing.
                stroke: { show: true, width: 2, colors: [token('--bisa-surface', '#ffffff')] },
                dataLabels: { enabled: false },
                legend: { position: 'top', horizontalAlign: 'right', labels: { colors: token('--bisa-text-muted', '#6b7280') } },
                grid: { borderColor: token('--bisa-border', '#e5e7eb'), strokeDashArray: 4 },
                xaxis: {
                    categories: months,
                    labels: { style: { colors: token('--bisa-text-muted', '#6b7280') } },
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: {
                    labels: {
                        style: { colors: token('--bisa-text-muted', '#6b7280') },
                        // Tahun lalu disimpan negatif; tampilkan nilai absolutnya.
                        formatter: function (value) { return Math.abs(Math.round(value)); }
                    }
                },
                tooltip: {
                    y: { formatter: function (value) { return Math.abs(value) + ' produk'; } }
                }
            }).render();

        })();
    </script>
@endpush
