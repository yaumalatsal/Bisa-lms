@section('title-page')
    Daftar Materi
@endsection

@extends('admin/template/index')

@section('content')
    <div class="container">
        <h1>Daftar Materi Inkubasi</h1>

        <!-- Tampilkan pesan sukses jika ada -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tombol Tambah Materi -->
        <a href="{{ route('admin.materi.create') }}" class="btn btn-primary mb-3">Tambah Materi</a>

        <!-- Tabel Daftar Materi --> 
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Bentuk</th>
                    <th>Link</th>
                    <th>Thumbnail</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($materi as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->judul }}</td>
                        <td>{{ ucfirst($item->kategori) }}</td>
                        <td>{{ ucfirst($item->bentuk_kategori) }}</td>
                        <td><a href="{{ $item->link }}" target="_blank">Lihat Link</a></td>
                        <td><img src="{{ asset('storage/' . $item->thumbnail) }}" width="100" alt="Thumbnail"></td>
                        <td>
                            <a href="{{ route('admin.materi.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.materi.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus materi ini?');">
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
@endsection
