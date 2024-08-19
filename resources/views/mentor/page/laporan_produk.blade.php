@extends('mentor/template/index')

@section('title-page')
    Laporan Bulanan Siswa
@endsection

@section('content')
<div class="container-fluid">
    <h2>Laporan Bulanan Siswa</h2>
    <br>
    <!-- Tabel untuk menampilkan laporan bulanan siswa -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Total Penjualan Produk</th>
                <th>Tanggal Laporan</th>
                <th>Pemasukan</th>
                <th>Pengeluaran</th>
                <th>Profit</th>
                <th>File Laporan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($monthlyReports as $report)
                <tr>
                    <td>{{ $report->product->nama_produk }}</td>
                    <td>{{ $report->total_sales }}</td>
                    <td>{{ $report->report_date->format('d-m-Y') }}</td>
                    <td>{{ $report->formatted_revenue }}</td>
                    <td>{{ $report->formatted_spending }}</td>
                    <td>{!! $report->formatted_profit !!}</td>
                    <td>
                        @if($report->file_path)
                            <a href="{{ asset('storage/' . $report->file_path) }}" target="_blank">Lihat Laporan</a>
                        @else
                            Tidak ada file
                        @endif
                    </td>
                    <td>
                        @if($report->status == 'disetujui')
                            <span class="badge bg-success">Disetujui</span>
                        @elseif($report->status == 'ditolak')
                            <span class="badge bg-danger">Ditolak</span>
                        @else
                            <form action="{{ route('mentor.page.laporan_produk.approve', $report->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Setujui</button>
                            </form>
                            <form action="{{ route('mentor.page.laporan_produk.reject', $report->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
