@extends('dashboard_template.index')
<TItle>BISa - Laporan Bulanan</TItle>

@section('css')
<style>
    /* General Styles */
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f4f7f6;
    }
    .container {
        padding: 20px;
        max-width: 800px;
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        margin-top: 40px;
    }
    h3 {
        font-weight: 600;
        color: #4e4e4e;
        margin-bottom: 20px;
    }
    hr {
        border-top: 2px solid #e0e0e0;
        margin-bottom: 30px;
    }

    /* Form Styles */
    .form-group {
        margin-bottom: 20px;
    }
    .form-label {
        font-weight: 500;
        color: #333;
        margin-bottom: 10px;
    }
    .form-control {
        height: 45px;
        border-radius: 5px;
        border: 1px solid #ddd;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }
    .form-control:focus {
        border-color: #6e8efb;
        box-shadow: 0 4px 12px rgba(110, 142, 251, 0.3);
    }

    /* Button Styles */
    .btn-primary {
        background: linear-gradient(135deg, #6e8efb, #a777e3);
        border: none;
        box-shadow: 0 4px 12px rgba(110, 142, 251, 0.4);
        transition: all 0.3s ease;
        padding: 12px 20px;
        font-size: 16px;
        border-radius: 5px;
    }
    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(110, 142, 251, 0.6);
    }

    /* File Input */
    .form-control-file {
        border: 2px dashed #ddd;
        padding: 10px;
        background-color: #f9f9f9;
        transition: all 0.3s ease;
    }
    .form-control-file:hover {
        border-color: #6e8efb;
    }

    /* Alert Styles */
    .alert {
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        animation: fadeIn 0.5s ease;
        padding: 15px;
    }

    /* Keyframes for Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }
</style>
@endsection

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
            <input type="file" name="file" id="file" class="form-control form-control-file" required>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
