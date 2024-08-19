@extends('dashboard_template.index')

@section('title-page')
    Laporan Bulanan
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

    <table class="table table-bordered">
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
                    <td>{!! $report->formatted_profit !!}</td>
                    
                    <!-- File Preview -->
                    <td>
                        @if($report->file_path)
                            <a href="{{ asset('storage/' . $report->file_path) }}" target="_blank" class="btn btn-info">
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
                        <a href="{{ route('dashboard.laporan.edit', $report->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('dashboard.laporan.destroy', $report->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
