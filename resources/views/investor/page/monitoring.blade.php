<!DOCTYPE html>




<html>

<head>
    @section('content')
        @extends('investor/template/index')
        <meta charset="utf-8" />
        <meta name="viewport"
            content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

        <title>Monitoring</title>

        <meta name="description" content="" />

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('sneat') }}/assets/img/favicon/favicon.ico" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
            rel="stylesheet" />

        <!-- Icons. Uncomment required icon fonts -->
        <link rel="stylesheet" href="{{ asset('sneat') }}/assets/vendor/fonts/boxicons.css" />

        <!-- Core CSS -->
        <link rel="stylesheet" href="{{ asset('sneat') }}/assets/vendor/css/core.css"
            class="template-customizer-core-css" />
        <link rel="stylesheet" href="{{ asset('sneat') }}/assets/vendor/css/theme-default.css"
            class="template-customizer-theme-css" />
        <link rel="stylesheet" href="{{ asset('sneat') }}/assets/css/demo.css" />

        <!-- Vendors CSS -->
        <link rel="stylesheet" href="{{ asset('sneat') }}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

        <link rel="stylesheet" href="{{ asset('sneat') }}/assets/vendor/libs/apex-charts/apex-charts.css" />

        <!-- Page CSS -->

        <!-- Helpers -->
        <script src="{{ asset('sneat') }}/assets/vendor/js/helpers.js"></script>

        <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
        <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
        <script src="{{ asset('sneat') }}/assets/js/config.js"></script>
    </head>

    <body>
        <!-- Content wrapper -->
        <div class="content-wrapper min-vh-100">
            <!-- Content -->


            @if ($monthlyReports)
                <div class="container-xxl flex-grow-1 container-p-y">
                    <div class="row">
                        <div class="col-lg-8 mb-4 order-0">
                            <div class="card">
                                <div class="d-flex align-items-end row">
                                    <div class="col-sm-7">
                                        <div class="card-body">
                                            {{-- <h5 class="card-title text-primary">Welcome {{ $siswa->nama }}! 🎉</h5> --}}

                                            <p class="mb-4">
                                                Selamat datang di laman <span class="fw-bold">Monitoring</span>. Pantau
                                                perkembangan bisnismu dan jadilah
                                                lebih hebat dari sebelumnya!
                                            </p>

                                            <a href="javascript:;" class="btn btn-sm btn-outline-primary">View Badges</a>
                                        </div>
                                    </div>
                                    <div class="col-sm-5 text-center text-sm-left">
                                        <div class="card-body pb-0 px-0 px-md-4">
                                            <img src="{{ asset('sneat') }}/assets/img/illustrations/man-with-laptop-light.png"
                                                height="140" alt="View Badge User"
                                                data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                                data-app-light-img="illustrations/man-with-laptop-light.png" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 order-1">
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-6 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="card-title d-flex align-items-start justify-content-between">
                                                <div class="avatar flex-shrink-0">
                                                    <img src="{{ asset('sneat') }}/assets/img/icons/unicons/chart-success.png"
                                                        alt="chart success" class="rounded" />
                                                </div>
                                                <div class="dropdown">
                                                    <button class="btn p-0" type="button" id="cardOpt3"
                                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                                        <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                                        <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="fw-semibold d-block mb-1">Total Profit</span>
                                            <h6 class="card-title mb-2">Rp.{{ number_format($totalProfit, 0, ',', '.') }}
                                                </h3>
                                                @if ($profitPercentageChange > 0)
                                                    <small class="text-success fw-semibold">
                                                        <i class="bx bx-up-arrow-alt"></i>
                                                        +{{ number_format($profitPercentageChange, 2) }}%
                                                    </small>
                                                @elseif($profitPercentageChange < 0)
                                                    <small class="text-danger fw-semibold">
                                                        <i class="bx bx-down-arrow-alt"></i>
                                                        {{ number_format($profitPercentageChange, 2) }}%
                                                    </small>
                                                @else
                                                    <small class="text-muted fw-semibold">Tidak Ada Perubahan</small>
                                                @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12 col-6 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="card-title d-flex align-items-start justify-content-between">
                                                <div class="avatar flex-shrink-0">
                                                    <img src="{{ asset('sneat') }}/assets/img/icons/unicons/wallet-info.png"
                                                        alt="Credit Card" class="rounded" />
                                                </div>
                                                <div class="dropdown">
                                                    <button class="btn p-0" type="button" id="cardOpt6"
                                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                                        <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                                        <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="fw-semibold d-block mb-1">Total Penjualan</span>
                                            <h6 class="card-title mb-2"> {{ number_format($totalSales, 0, ',', '.') }}
                                                Produk
                                                </h3>
                                                @if ($salesPercentageChange > 0)
                                                    <small class="text-success fw-semibold">
                                                        <i class="bx bx-up-arrow-alt"></i>
                                                        +{{ number_format($salesPercentageChange, 2) }}%
                                                    </small>
                                                @elseif($salesPercentageChange < 0)
                                                    <small class="text-danger fw-semibold">
                                                        <i class="bx bx-down-arrow-alt"></i>
                                                        {{ number_format($salesPercentageChange, 2) }}%
                                                    </small>
                                                @else
                                                    <small class="text-muted fw-semibold">Tidak Ada Perubahan</small>
                                                @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Total Revenue -->
                        <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
                            <div class="card">
                                <div class="row row-bordered g-0">
                                    <div class="col-md-8">
                                        <h5 class="card-header m-0 me-2 pb-3">Perkembangan Penjualan Produk</h5>
                                        <div id="totalRevenueChart" class="px-2"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card-body">
                                            <div class="text-center">
                                                {{-- <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-primary dropdown-toggle"
                                                    type="button" id="growthReportId" data-bs-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    {{ now()->year }}
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end"
                                                    aria-labelledby="growthReportId">
                                                    @foreach (range(now()->year, now()->year - 3) as $year)
                                                        <a class="dropdown-item" href="#"
                                                            data-year="{{ $year }}">{{ $year }}</a>
                                                    @endforeach
                                                </div>
                                            </div> --}}
                                                {{ $currentYear }}
                                            </div>
                                            <div id="growthChart"></div>
                                            <div class="text-center fw-semibold pt-3 mb-2">{{ $salesGrowth }}% Growth
                                                from
                                                last year</div>

                                            <div
                                                class="d-flex px-xxl-4 px-lg-2 p-4 gap-xxl-3 gap-lg-1 gap-3 justify-content-between">
                                                <div class="d-flex">
                                                    <div class="me-2">
                                                        <span class="badge bg-label-primary p-2"><i
                                                                class="bx bx-dollar text-primary"></i></span>
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <small>Year {{ $currentYear }}</small>
                                                        <h6 class="mb-0">{{ $thisYearSales }} Produk</h6>
                                                    </div>
                                                </div>
                                                <div class="d-flex">
                                                    <div class="me-2">
                                                        <span class="badge bg-label-info p-2"><i
                                                                class="bx bx-wallet text-info"></i></span>
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <small>Year {{ $previousYear }}</small>
                                                        <h6 class="mb-0">{{ $lastYearSales }} Produk</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!--/ Total Revenue -->
                        <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
                            <div class="row">
                                <div class="col-6 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="card-title d-flex align-items-start justify-content-between">
                                                <div class="avatar flex-shrink-0">
                                                    <img src="{{ asset('sneat') }}/assets/img/icons/unicons/paypal.png"
                                                        alt="Credit Card" class="rounded" />
                                                </div>
                                                <div class="dropdown">
                                                    <button class="btn p-0" type="button" id="cardOpt4"
                                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end"
                                                        aria-labelledby="cardOpt4">
                                                        <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                                        <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                                    </div>
                                                </div>
                                            </div>

                                            <span class="fw-semibold d-block mb-1">Total Pemasukan</span>
                                            <h6 class="card-title mb-2">Rp.{{ number_format($totalRevenue, 0, ',', '.') }}
                                                </h3>
                                                @if ($revenuePercentageChange > 0)
                                                    <small class="text-success fw-semibold">
                                                        <i class="bx bx-up-arrow-alt"></i>
                                                        +{{ number_format($revenuePercentageChange, 2) }}%
                                                    </small>
                                                @elseif($revenuePercentageChange < 0)
                                                    <small class="text-danger fw-semibold">
                                                        <i class="bx bx-down-arrow-alt"></i>
                                                        {{ number_format($revenuePercentageChange, 2) }}%
                                                    </small>
                                                @else
                                                    <small class="text-muted fw-semibold">Tidak Ada Perubahan</small>
                                                @endif

                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="card-title d-flex align-items-start justify-content-between">
                                                <div class="avatar flex-shrink-0">
                                                    <img src="{{ asset('sneat') }}/assets/img/icons/unicons/cc-primary.png"
                                                        alt="Credit Card" class="rounded" />
                                                </div>
                                                <div class="dropdown">
                                                    <button class="btn p-0" type="button" id="cardOpt1"
                                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="cardOpt1">
                                                        <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                                        <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="fw-semibold d-block mb-1">Total Pengeluaran</span>
                                            <h6 class="card-title mb-2">Rp.
                                                {{ number_format($totalSpending, 0, ',', '.') }}
                                                </h3>
                                                @if ($spendingPercentageChange > 0)
                                                    <small class="text-success fw-semibold">
                                                        <i class="bx bx-up-arrow-alt"></i>
                                                        +{{ number_format($spendingPercentageChange, 2) }}%
                                                    </small>
                                                @elseif($spendingPercentageChange < 0)
                                                    <small class="text-danger fw-semibold">
                                                        <i class="bx bx-down-arrow-alt"></i>
                                                        {{ number_format($spendingPercentageChange, 2) }}%
                                                    </small>
                                                @else
                                                    <small class="text-muted fw-semibold">Tidak Ada Perubahan</small>
                                                @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                                                <div
                                                    class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                                    <div class="card-title">
                                                        <h5 class="text-nowrap mb-2">Profit Tahunan</h5>
                                                        <span class="badge bg-label-warning rounded-pill">Year
                                                            {{ now()->year }}</span>
                                                    </div>
                                                    <div class="mt-sm-auto">
                                                        <small class="text-nowrap fw-semibold">
                                                            @if ($profitPercentage > 0)
                                                                <i class="bx bx-chevron-up text-success"></i>
                                                                +{{ number_format($profitPercentage, 2) }}%
                                                            @elseif($profitPercentage < 0)
                                                                <i class="bx bx-chevron-down text-danger"></i>
                                                                {{ number_format($profitPercentage, 2) }}%
                                                            @else
                                                                <i class="bx bx-minus"></i>
                                                                0%
                                                            @endif
                                                        </small>
                                                        <h3 class="mb-0">
                                                            Rp.{{ number_format($currentYearProfit, 0, ',', '.') }}</h3>
                                                    </div>
                                                </div>
                                                <div id="profileReportChart"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="row">
                    <!-- Order Statistics -->
                    <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-4">
                        <div class="card h-100">
                            <div class="card-header d-flex align-items-center justify-content-between pb-0">
                                <div class="card-title mb-0">
                                    <h5 class="m-0 me-2">Order Statistics</h5>
                                    <small class="text-muted">42.82k Total Sales</small>
                                </div>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="orederStatistics"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">
                                        <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Share</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="d-flex flex-column align-items-center gap-1">
                                        <h2 class="mb-2">8,258</h2>
                                        <span>Total Orders</span>
                                    </div>
                                    <div id="orderStatisticsChart"></div>
                                </div>
                                <ul class="p-0 m-0">
                                    <li class="d-flex mb-4 pb-1">
                                        <div class="avatar flex-shrink-0 me-3">
                                            <span class="avatar-initial rounded bg-label-primary"><i
                                                    class="bx bx-mobile-alt"></i></span>
                                        </div>
                                        <div
                                            class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0">Electronic</h6>
                                                <small class="text-muted">Mobile, Earbuds, TV</small>
                                            </div>
                                            <div class="user-progress">
                                                <small class="fw-semibold">82.5k</small>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-flex mb-4 pb-1">
                                        <div class="avatar flex-shrink-0 me-3">
                                            <span class="avatar-initial rounded bg-label-success"><i
                                                    class="bx bx-closet"></i></span>
                                        </div>
                                        <div
                                            class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0">Fashion</h6>
                                                <small class="text-muted">T-shirt, Jeans, Shoes</small>
                                            </div>
                                            <div class="user-progress">
                                                <small class="fw-semibold">23.8k</small>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-flex mb-4 pb-1">
                                        <div class="avatar flex-shrink-0 me-3">
                                            <span class="avatar-initial rounded bg-label-info"><i
                                                    class="bx bx-home-alt"></i></span>
                                        </div>
                                        <div
                                            class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0">Decor</h6>
                                                <small class="text-muted">Fine Art, Dining</small>
                                            </div>
                                            <div class="user-progress">
                                                <small class="fw-semibold">849k</small>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-flex">
                                        <div class="avatar flex-shrink-0 me-3">
                                            <span class="avatar-initial rounded bg-label-secondary"><i
                                                    class="bx bx-football"></i></span>
                                        </div>
                                        <div
                                            class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0">Sports</h6>
                                                <small class="text-muted">Football, Cricket Kit</small>
                                            </div>
                                            <div class="user-progress">
                                                <small class="fw-semibold">99</small>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!--/ Order Statistics -->

                    <!-- Expense Overview -->
                    <div class="col-md-6 col-lg-4 order-1 mb-4">
                        <div class="card h-100">
                            <div class="card-header">
                                <ul class="nav nav-pills" role="tablist">
                                    <li class="nav-item">
                                        <button type="button" class="nav-link active" role="tab"
                                            data-bs-toggle="tab" data-bs-target="#navs-tabs-line-card-income"
                                            aria-controls="navs-tabs-line-card-income" aria-selected="true">
                                            Income
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" class="nav-link" role="tab">Expenses</button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" class="nav-link" role="tab">Profit</button>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body px-0">
                                <div class="tab-content p-0">
                                    <div class="tab-pane fade show active" id="navs-tabs-line-card-income"
                                        role="tabpanel">
                                        <div class="d-flex p-4 pt-3">
                                            <div class="avatar flex-shrink-0 me-3">
                                                <img src="{{ asset('sneat') }}/assets/img/icons/unicons/wallet.png"
                                                    alt="User" />
                                            </div>
                                            <div>
                                                <small class="text-muted d-block">Total Balance</small>
                                                <div class="d-flex align-items-center">
                                                    <h6 class="mb-0 me-1">$459.10</h6>
                                                    <small class="text-success fw-semibold">
                                                        <i class="bx bx-chevron-up"></i>
                                                        42.9%
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="incomeChart"></div>
                                        <div class="d-flex justify-content-center pt-4 gap-2">
                                            <div class="flex-shrink-0">
                                                <div id="expensesOfWeek"></div>
                                            </div>
                                            <div>
                                                <p class="mb-n1 mt-1">Expenses This Week</p>
                                                <small class="text-muted">$39 less than last week</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Expense Overview -->

                    <!-- Transactions -->
                    <div class="col-md-6 col-lg-4 order-2 mb-4">
                        <div class="card h-100">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <h5 class="card-title m-0 me-2">Transactions</h5>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="transactionID" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
                                        <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <ul class="p-0 m-0">
                                    <li class="d-flex mb-4 pb-1">
                                        <div class="avatar flex-shrink-0 me-3">
                                            <img src="{{ asset('sneat') }}/assets/img/icons/unicons/paypal.png"
                                                alt="User" class="rounded" />
                                        </div>
                                        <div
                                            class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <small class="text-muted d-block mb-1">Paypal</small>
                                                <h6 class="mb-0">Send money</h6>
                                            </div>
                                            <div class="user-progress d-flex align-items-center gap-1">
                                                <h6 class="mb-0">+82.6</h6>
                                                <span class="text-muted">USD</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-flex mb-4 pb-1">
                                        <div class="avatar flex-shrink-0 me-3">
                                            <img src="{{ asset('sneat') }}/assets/img/icons/unicons/wallet.png"
                                                alt="User" class="rounded" />
                                        </div>
                                        <div
                                            class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <small class="text-muted d-block mb-1">Wallet</small>
                                                <h6 class="mb-0">Mac'D</h6>
                                            </div>
                                            <div class="user-progress d-flex align-items-center gap-1">
                                                <h6 class="mb-0">+270.69</h6>
                                                <span class="text-muted">USD</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-flex mb-4 pb-1">
                                        <div class="avatar flex-shrink-0 me-3">
                                            <img src="{{ asset('sneat') }}/assets/img/icons/unicons/chart.png"
                                                alt="User" class="rounded" />
                                        </div>
                                        <div
                                            class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <small class="text-muted d-block mb-1">Transfer</small>
                                                <h6 class="mb-0">Refund</h6>
                                            </div>
                                            <div class="user-progress d-flex align-items-center gap-1">
                                                <h6 class="mb-0">+637.91</h6>
                                                <span class="text-muted">USD</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-flex mb-4 pb-1">
                                        <div class="avatar flex-shrink-0 me-3">
                                            <img src="{{ asset('sneat') }}/assets/img/icons/unicons/cc-success.png"
                                                alt="User" class="rounded" />
                                        </div>
                                        <div
                                            class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <small class="text-muted d-block mb-1">Credit Card</small>
                                                <h6 class="mb-0">Ordered Food</h6>
                                            </div>
                                            <div class="user-progress d-flex align-items-center gap-1">
                                                <h6 class="mb-0">-838.71</h6>
                                                <span class="text-muted">USD</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-flex mb-4 pb-1">
                                        <div class="avatar flex-shrink-0 me-3">
                                            <img src="{{ asset('sneat') }}/assets/img/icons/unicons/wallet.png"
                                                alt="User" class="rounded" />
                                        </div>
                                        <div
                                            class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <small class="text-muted d-block mb-1">Wallet</small>
                                                <h6 class="mb-0">Starbucks</h6>
                                            </div>
                                            <div class="user-progress d-flex align-items-center gap-1">
                                                <h6 class="mb-0">+203.33</h6>
                                                <span class="text-muted">USD</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-flex">
                                        <div class="avatar flex-shrink-0 me-3">
                                            <img src="{{ asset('sneat') }}/assets/img/icons/unicons/cc-warning.png"
                                                alt="User" class="rounded" />
                                        </div>
                                        <div
                                            class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <small class="text-muted d-block mb-1">Mastercard</small>
                                                <h6 class="mb-0">Ordered Food</h6>
                                            </div>
                                            <div class="user-progress d-flex align-items-center gap-1">
                                                <h6 class="mb-0">-92.45</h6>
                                                <span class="text-muted">USD</span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!--/ Transactions -->
                </div> --}}
                </div>
            @else
                <div class="col-lg-12">
                    <div class="alert alert-warning text-center" role="alert">
                      <h3>{{ $message }}</h3>
                        
                    </div>
                </div>
            @endif

            <!-- / Content -->
            <div class="content-backdrop fade"></div>
        </div>
        <!-- Content wrapper -->

        <!-- Core JS -->
        <!-- build:js assets/vendor/js/core.js -->
        <script src="{{ asset('sneat') }}/assets/vendor/libs/jquery/jquery.js"></script>
        <script src="{{ asset('sneat') }}/assets/vendor/libs/popper/popper.js"></script>

        <script src="{{ asset('sneat') }}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

        <script src="{{ asset('sneat') }}/assets/vendor/js/menu.js"></script>
        <!-- endbuild -->

        <!-- Vendors JS -->
        <script src="{{ asset('sneat') }}/assets/vendor/libs/apex-charts/apexcharts.js"></script>

        <!-- Main JS -->
        <script src="{{ asset('sneat') }}/assets/js/main.js"></script>

        <script>
            var chartData = {{ $salesGrowth ?? 0 }};
            var tahunLalu = {{ $previousYear ?? 0 }};
            var tahunSekarang = {{ $currentYear ?? 0 }};
            var chartTahunSekarang = @json($monthlySalesThisYear ?? array_fill(0, 12, 0));
            var chartTahunLalu = @json($monthlySalesLastYear ?? array_fill(0, 12, 0));
            var reportChartThisYear = @json($monthlyProfitThisYear ?? array_fill(0, 12, 0));

        </script>
        <!-- Page JS -->
        <script src="{{ asset('sneat') }}/assets/js/dashboards-analytics.js"></script>

        <!-- Place this tag in your head or just before your close body tag. -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>
    @endsection
</body>

</html>
