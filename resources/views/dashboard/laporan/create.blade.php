@extends('dashboard_template.index')

<title>Buat Laporan Bulanan</title>

@section('content')
<div class="container">
    <h3>Buat Laporan Bulanan</h3>
    <hr>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('dashboard.laporan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="product_id" class="form-label">Pilih Produk</label>
            <select name="product_id" id="product_id" class="form-control" required>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->nama_produk }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="total_sales">Total Penjualan Produk</label>
            <input type="number" name="total_sales" id="total_sales" class="form-control" value="{{ old('total_sales') }}" required>
        </div>

        <div class="form-group">
            <label for="report_date">Tanggal Laporan</label>
            <input type="date" class="form-control" id="report_date" name="report_date" required>
        </div>

        <div class="form-group">
            <label for="revenue">Pemasukan (Dalam Rupiah)</label>
            <input type="text" name="revenue" id="revenue" class="form-control" value="{{ old('revenue') }}" required>
        </div>

        <div class="form-group">
            <label for="spending">Pengeluaran (Dalam Rupiah)</label>
            <input type="text" name="spending" id="spending" class="form-control" value="{{ old('spending') }}" required>
        </div>

        <div class="mb-3">
            <label for="file" class="form-label">Unggah Laporan (PDF)</label>
            <input type="file" name="file" id="file" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
