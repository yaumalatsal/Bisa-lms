@extends('admin/template/index')



@section('content')
    <div class="container">
        <h1>Edit Mapel</h1>
        <form action="{{ route('admin.mapels.update', $mapel->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Nama Mapel</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $mapel->name }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection