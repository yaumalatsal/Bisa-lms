@extends('dashboard_template.index')

@section('title-page')
    Laporan Bulanan
@endsection

@section('content')
<div class="container-fluid">
    <a href="{{ url('laporan/create') }}" class="btn btn-primary mb-3">Tambah Laporan Bulanan</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Total Penjualan Produk</th>
                <th>Tanggal Laporan</th>
                <th>Pemasukan</th>
                <th>Pengeluaran</th>
                <th>Profit</th>
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
                    <td>{{ $report->spending }}</td>
                    <td>{!! $report->formatted_profit !!}</td>
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
