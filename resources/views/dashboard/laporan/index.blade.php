@extends('dashboard_template.index')

@section('title-page')
    Laporan Bulanan
@endsection

@section('css')
<style>
    /* General Styles */
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f4f7f6;
    }
    .container-fluid {
        padding: 20px;
    }
    .card, .table {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Button Styles */
    .btn-primary {
        background: linear-gradient(135deg, #6e8efb, #a777e3);
        border: none;
        box-shadow: 0 4px 12px rgba(110, 142, 251, 0.4);
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(110, 142, 251, 0.6);
    }

    /* Alert Styles */
    .alert {
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        animation: fadeIn 0.5s ease;
    }

    /* Table Styles */
    
    .table tbody tr {
        transition: all 0.3s ease;
    }
    .table tbody tr:hover {
        background-color: #f2f4ff;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(110, 142, 251, 0.1);
    }

    /* Status Badges */
    .badge {
        border-radius: 20px;
        padding: 5px 10px;
        font-size: 0.9rem;
    }
    .badge-success {
        background: linear-gradient(135deg, #56d798, #56dfb6);
        box-shadow: 0 4px 12px rgba(86, 215, 152, 0.4);
    }
    .badge-danger {
        background: linear-gradient(135deg, #ff6a6a, #ff8f8f);
        box-shadow: 0 4px 12px rgba(255, 106, 106, 0.4);
    }
    .badge-warning {
        background: linear-gradient(135deg, #f9ca24, #f4e285);
        box-shadow: 0 4px 12px rgba(249, 202, 36, 0.4);
    }

    /* Modal Animation */
    .modal-content {
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        animation: slideIn 0.6s ease;
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

    @keyframes slideIn {
        from {
            transform: translateY(-20px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <a href="{{ url('laporan/create') }}" class="btn btn-primary mb-3">Tambah Laporan Bulanan</a>

    <!-- Display success or error messages -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="table-responsive">
        <table id="table-one" class="table table-striped table-hover table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Nama Produk</th>
                    <th>Total Penjualan Produk</th>
                    <th>Tanggal Laporan</th>
                    <th>Pemasukan</th>
                    <th>Pengeluaran</th>
                    <th>Profit</th>
                    <th>File</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reports as $report)
                    <tr>
                        <td>{{ $report->product->nama_produk }}</td>
                        <td>{{ $report->total_sales }}</td>
                        <td>{{ $report->report_date->format('d-m-Y') }}</td>
                        <td>{{ $report->formatted_revenue }}</td>
                        <td>{{ $report->formatted_spending }}</td>
                        <td>{!! $report->formatted_profit !!}</td>
                        
                        <!-- File Preview -->
                        <td>
                            @if($report->file_path)
                                <a href="{{ asset('storage/' . $report->file_path) }}" target="_blank" class="btn btn-info btn-sm">
                                    Preview PDF
                                </a>
                            @else
                                <span class="text-muted">Tidak ada file</span>
                            @endif
                        </td>

                        <!-- Status -->
                        <td>
                            @if($report->status === 'disetujui')
                                <span class="badge badge-success">Disetujui</span>
                            @elseif($report->status === 'ditolak')
                                <span class="badge badge-danger">Ditolak</span>
                            @else
                                <span class="badge badge-warning">Pending</span>
                            @endif
                        </td>
                        
                        <td>
                            <a href="{{ route('dashboard.laporan.edit', $report->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('dashboard.laporan.destroy', $report->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('js')
    <script>
        $(function() {
            $("#table-one").DataTable();
        });
    </script>
@endsection
