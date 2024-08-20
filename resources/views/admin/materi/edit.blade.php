@section('title-page')
    Edit Materi Inkubasi
@endsection

@extends('admin/template/index')

@section('content')
    <div class="container">
        <h1>Edit Materi Inkubasi</h1>

        <form action="{{ route('materi.update', $materi->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="judul">Judul</label>
                <input type="text" name="judul" id="judul" class="form-control" value="{{ $materi->judul }}" required>
            </div>

            <div class="form-group">
                <label for="kategori">Kategori</label>
                <select name="kategori" id="kategori" class="form-control" required>
                    <option value="bmc" {{ $materi->kategori == 'bmc' ? 'selected' : '' }}>BMC</option>
                    <option value="ide bisnis" {{ $materi->kategori == 'ide bisnis' ? 'selected' : '' }}>Ide Bisnis</option>
                    <option value="cara memulai bisnis" {{ $materi->kategori == 'cara memulai bisnis' ? 'selected' : '' }}>Cara Memulai Bisnis</option>
                </select>
            </div>

            <div class="form-group">
                <label for="bentuk_kategori">Bentuk Kategori</label>
                <select name="bentuk_kategori" id="bentuk_kategori" class="form-control" required>
                    <option value="artikel" {{ $materi->bentuk_kategori == 'artikel' ? 'selected' : '' }}>Artikel</option>
                    <option value="video" {{ $materi->bentuk_kategori == 'video' ? 'selected' : '' }}>Video</option>
                </select>
            </div>

            <div class="form-group">
                <label for="link">Link (Artikel/Video)</label>
                <input type="url" name="link" id="link" class="form-control" value="{{ $materi->link }}">
            </div>

            <div class="form-group">
                <label for="thumbnail">Thumbnail</label>
                <input type="file" name="thumbnail" id="thumbnail" class="form-control-file">
                @if($materi->thumbnail)
                    <img src="{{ asset('storage/' . $materi->thumbnail) }}" width="100" alt="Thumbnail">
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
