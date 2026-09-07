@extends('dashboard_template.index')

@section('title-page')
    Laporan Bulanan
@endsection

@section('css')
<style>
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
            <thead>
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
                        <td class="text-end bisa-numeric">
                            @php($p = $report->profit)
                            <span class="bisa-stat__delta {{ $p >= 0 ? 'bisa-stat__delta--up' : 'bisa-stat__delta--down' }}">
                                <i class="mdi {{ $p >= 0 ? 'mdi-arrow-up' : 'mdi-arrow-down' }}" aria-hidden="true"></i>
                                {{ $report->formatted_profit }}
                            </span>
                        </td>
                        
                        <!-- File Preview -->
                        <td>
                            @if($report->file_path)
                                <a href="{{ asset('storage/' . $report->file_path) }}" target="_blank" class="btn btn-secondary btn-sm">
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
                            <a href="{{ route('dashboard.laporan.edit', $report->id) }}" class="btn btn-secondary btn-sm">Edit</a>
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
            $("#table-one").DataTable({
                "ordering": false, // Disable ordering
                "paging": true,   // Enable pagination
                "info": true       // Show table info
            });
        });
    </script>
@endsection
