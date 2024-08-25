@extends('dashboard_template.index')

<title>BISa - Edit Laporan Bulanan</title>

@section('css')
<style>
    /* General Styles */

    .container-fluid {
        padding: 30px;
        max-width: 900px;
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        margin-top: 40px;
    }
    h2 {
        font-weight: 600;
        color: #4e4e4e;
        margin-bottom: 25px;
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
    .btn-info {
        background: linear-gradient(135deg, #4ecdc4, #556270);
        border: none;
        box-shadow: 0 4px 12px rgba(78, 205, 196, 0.4);
        transition: all 0.3s ease;
        padding: 8px 16px;
        font-size: 14px;
        border-radius: 5px;
        color: #fff;
    }
    .btn-info:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(78, 205, 196, 0.6);
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
<div class="container-fluid">
    <h2>Edit Laporan Bulanan</h2>

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
            <input type="file" name="file" id="file" class="form-control form-control-file">
            <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti file yang sudah ada.</small>
        </div>

        <button type="submit" class="btn btn-primary">Perbarui Laporan</button>
    </form>
</div>
@endsection
