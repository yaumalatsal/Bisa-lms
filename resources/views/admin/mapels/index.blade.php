@extends('admin/template/index')

@section('title', 'Daftar Mapel')

@section('content')
    <div class="container">
        <h1>Daftar Mapel</h1>
        <a href="{{ route('admin.mapels.create') }}" class="btn btn-primary">Tambah Mapel</a>   
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Mapel</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($mapels as $mapel)
                    <tr>
                        <td>{{ $mapel->id }}</td>
                        <td>{{ $mapel->name }}</td>
                        <td>
                            <a href="{{ route('admin.mapels.edit', $mapel->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('admin.mapels.destroy', $mapel->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                            <a href="{{ route('admin.quiz_soals.index', ['mapel_id' => $mapel->id]) }}" class="btn btn-info">Kelola Soal</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
