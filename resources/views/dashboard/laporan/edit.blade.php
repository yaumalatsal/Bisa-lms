@extends('dashboard_template.index')

@section('title-page', 'Edit Monthly Report')

@section('content')
<div class="container-fluid">
    <h2>Edit Monthly Report</h2>

    <!-- Display validation errors if any -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form to edit the report -->
    <form action="{{ route('dashboard.laporan.update', $report->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="total_sales">Total Penjualan Produk</label>
            <input type="number" name="total_sales" id="total_sales" class="form-control" value="{{ old('total_sales', $report->total_sales) }}" required>
        </div>

        <div class="form-group">
            <label for="revenue">Pemasukan</label>
            <input type="number" name="revenue" id="revenue" class="form-control" value="{{ old('revenue', $report->revenue) }}" required>
        </div>

        <div class="form-group">
            <label for="spending">Pengeluaran</label>
            <input type="number" name="spending" id="spending" class="form-control" value="{{ old('spending', $report->spending) }}" required>
        </div>

        <div class="form-group">
            <label for="report_date">Tanggal Laporan</label>
            <input type="date" name="report_date" id="report_date" class="form-control" value="{{ old('report_date', $report->report_date->format('Y-m-d')) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Report</button>
    </form>
</div>
@endsection
