@extends('dashboard_template.index')

@section('title-page')
    Edit Laporan Bulanan
@endsection

@section('content')
<div class="container-fluid">
    <h2>Edit Laporan Bulanan</h2>
    <br>
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
    <form action="{{ route('dashboard.laporan.update', $report->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="product_id" class="form-label">Pilih Produk</label>
            <select name="product_id" id="product_id" class="form-control" required>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ $report->product_id == $product->id ? 'selected' : '' }}>
                        {{ $product->nama_produk }}
                    </option>
                @endforeach
            </select>
        </div>

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

        <!-- File Preview -->
        <div class="form-group">
            <label for="file" class="form-label">Unggah Ulang Laporan (PDF)</label>
            @if($report->file_path)
                <a href="{{ asset('storage/' . $report->file_path) }}" target="_blank" class="btn btn-info mb-2">
                    Preview PDF
                </a>
            @endif
            <input type="file" name="file" id="file" class="form-control">
            <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti file yang sudah ada.</small>
        </div>

        <button type="submit" class="btn btn-primary">Perbarui Laporan</button>
    </form>
</div>
@endsection
