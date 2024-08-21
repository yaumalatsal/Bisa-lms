@extends('admin/template/index')

@section('title-page', 'Kelola BMC')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar BMC</h1>

    <!-- Notifikasi Berhasil CRUD -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Tombol Tambah BMC -->
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('admin.bmc.create') }}" class="btn btn-success">Tambah BMC</a>
    </div>
    
    <table class="table table-hover table-bordered">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Route</th>
                <th>Icon</th>
                <th>Video</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bmcs as $index => $bmc)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $bmc->judul }}</td>
                    <td>{{ $bmc->deskripsi }}</td>
                    <td>{{ $bmc->route }}</td>
                    <td>{{ $bmc->icon }}</td>
                    <td>{{ $bmc->video }}</td>
                    <td>
                        <a href="{{ route('admin.bmc.edit', $bmc->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <a href="{{ route('admin.bmc.soal.index', $bmc->id) }}" class="btn btn-info btn-sm">Kelola Sub Soal</a>
                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $bmc->id }}">Hapus</button>
                    </td>
                </tr>
                
                <!-- Pop-up Konfirmasi Hapus -->
                <div class="modal fade" id="deleteModal-{{ $bmc->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Apakah Anda yakin ingin menghapus BMC dengan judul <strong>{{ $bmc->judul }}</strong>?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <form action="{{ route('admin.bmc.destroy', $bmc->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
