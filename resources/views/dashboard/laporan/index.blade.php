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
        {{-- reportsTable --}}
        <table id="table-one" class="table table-one table-striped table-hover table-bordered ">
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

@section('js')
    <script>
        $(function() {
            $("#table-one").DataTable();
        });

        
        
    </script>
@endsection