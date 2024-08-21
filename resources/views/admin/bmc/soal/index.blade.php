@extends('admin/template/index')

@section('title-page', 'Kelola Soal - ' . $bmc->judul)

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Soal - {{ $bmc->judul }}</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('admin.bmc.soal.create', $bmc->id) }}" class="btn btn-primary mb-4">Tambah Soal</a>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Pertanyaan</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($soals as $index => $soal)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $soal->pertanyaan }}</td>
                    <td>{{ $soal->keterangan }}</td>
                    <td>
                        <a href="{{ route('admin.bmc.soal.edit', [$bmc->id, $soal->id]) }}" class="btn btn-warning btn-sm">Edit</a>
                        <button class="btn btn-danger btn-sm" onclick="confirmDelete('{{ route('admin.bmc.soal.destroy', [$bmc->id, $soal->id]) }}')">Hapus</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Script untuk konfirmasi hapus -->
<script>
    function confirmDelete(url) {
        if (confirm('Anda yakin ingin menghapus soal ini?')) {
            window.location.href = url;
        }
    }
</script>
@endsection
