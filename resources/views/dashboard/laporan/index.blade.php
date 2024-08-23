@extends('dashboard_template.index')

@section('title-page')
    Laporan Bulanan
@endsection

@section('content')
<div class="container-fluid">
    <a href="{{ url('laporan/create') }}" class="btn btn-primary mb-3 animated fadeIn ">Tambah Laporan Bulanan</a>

    <!-- Display success or error messages -->
    @if(session('success'))
        <div class="alert alert-success animated bounceIn">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger animated bounceIn">
            {{ session('error') }}
        </div>
    @endif

    <div class="table-responsive animated fadeInUp shake">
        <table id="reportsTable" class="table table-striped table-hover table-bordered">
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
                    <tr class="animated fadeIn">
                        <td>{{ $report->product->nama_produk }}</td>
                        <td>{{ $report->total_sales }}</td>
                        <td>{{ $report->report_date->format('d-m-Y') }}</td>
                        <td>{{ $report->formatted_revenue }}</td>
                        <td>{{ $report->formatted_spending }}</td>
                        <td>{!! $report->formatted_profit !!}</td>
                        
                        <!-- File Preview -->
                        <td>
                            @if($report->file_path)
                                <a href="{{ asset('storage/' . $report->file_path) }}" target="_blank" class="btn btn-info btn-sm animated pulse">
                                    Preview PDF
                                </a>
                            @else
                                <span class="text-muted">Tidak ada file</span>
                            @endif
                        </td>

                        <!-- Status -->
                        <td>
                            @if($report->status === 'disetujui')
                                <span class="badge bg-success">Disetujui</span>
                            @elseif($report->status === 'ditolak')
                                <span class="badge bg-danger">Ditolak</span>
                            @else
                                <span class="badge bg-warning">Pending</span>
                            @endif
                        </td>
                        
                        <td>
                            <a href="{{ route('dashboard.laporan.edit', $report->id) }}" class="btn btn-warning btn-sm animated zoomIn">Edit</a>
                            <form action="{{ route('dashboard.laporan.destroy', $report->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm animated rounded-2 " style="color: #f8f9fa !important">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<style>
    .table {
        border-collapse: separate;
        border-spacing: 0;
    }

    .table th, .table td {
        vertical-align: middle;
    }

    .table th {
        background-color: #343a40;
        color: white;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
        transition: background-color 0.3s ease;
    }

    .table td {
        border-top: 1px solid #dee2e6;
    }

    .btn {
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    .btn:hover {
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        transform: translateY(-2px);
    }

    .btn-info.btn-sm, .btn-warning.btn-sm, .btn-danger.btn-sm {
        font-size: 0.875rem;
    }

    .alert {
        border-radius: 0.25rem;
        margin-bottom: 1rem;
        padding: 0.75rem 1.25rem;
    }

    .animated {
        animation-duration: 1s;
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#reportsTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "language": {
                "lengthMenu": "Tampilkan _MENU_ baris",
                "zeroRecords": "Tidak ditemukan data",
                "info": "Menampilkan _PAGE_ dari _PAGES_",
                "infoEmpty": "Tidak ada data",
                "infoFiltered": "(disaring dari _MAX_ total data)",
                "search": "Cari:",
                "paginate": {
                    "previous": "Sebelumnya",
                    "next": "Selanjutnya"
                }
            }
        });

        // Custom confirmation before delete
        $('form').on('submit', function(e) {
            if (!confirm('Are you sure you want to delete this item?')) {
                e.preventDefault();
            }
        });

        // Page Load Animation
        $(window).on('load', function() {
            $('.container-fluid').addClass('animated fadeIn');
        });
    });
</script>
@endpush
