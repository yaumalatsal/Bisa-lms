@extends('admin/template/index')

@section('content')
    <div class="container">
        <h1>Tambah Mapel</h1>
        <form action="{{ route('admin.mapels.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nama Mapel</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
@endsection