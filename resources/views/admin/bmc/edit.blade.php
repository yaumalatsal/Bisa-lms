@extends('admin/template/index')

@section('title-page', 'Edit BMC')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit BMC</h1>

    <form action="{{ route('admin.bmc.update', $bmc->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Form Fields -->
        <div class="form-group">
            <label for="judul">Judul</label>
            <input type="text" class="form-control" id="judul" name="judul" value="{{ $bmc->judul }}" required>
        </div>

        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" required>{{ $bmc->deskripsi }}</textarea>
        </div>

        <div class="form-group">
            <label for="route">Route</label>
            <input type="text" class="form-control" id="route" name="route" value="{{ $bmc->route }}" required>
        </div>

        <div class="form-group">
            <label for="icon">Icon</label>
            <input type="text" class="form-control" id="icon" name="icon" value="{{ $bmc->icon }}" required>
        </div>

        <div class="form-group">
            <label for="video">Video</label>
            <input type="text" class="form-control" id="video" name="video" value="{{ $bmc->video }}">
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('admin.bmc.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
