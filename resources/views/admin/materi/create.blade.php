@section('title-page')
    Tambah Materi Inkubasi
@endsection

@extends('admin/template/index')

@section('content')
    <div class="container">
        <h1>Tambah Materi Inkubasi</h1>

        <form action="{{ route('materi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="judul">Judul</label>
                <input type="text" name="judul" id="judul" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="kategori">Kategori</label>
                <select name="kategori" id="kategori" class="form-control" required>
                    <option value="bmc">BMC</option>
                    <option value="ide bisnis">Ide Bisnis</option>
                    <option value="cara memulai bisnis">Cara Memulai Bisnis</option>
                </select>
            </div>

            <div class="form-group">
                <label for="bentuk_kategori">Bentuk Kategori</label>
                <select name="bentuk_kategori" id="bentuk_kategori" class="form-control" required>
                    <option value="artikel">Artikel</option>
                    <option value="video">Video</option>
                </select>
            </div>

            <div class="form-group">
                <label for="link">Link (Artikel/Video)</label>
                <input type="url" name="link" id="link" class="form-control">
            </div>

            <div class="form-group">
                <label for="thumbnail">Thumbnail</label>
                <input type="file" name="thumbnail" id="thumbnail" class="form-control-file" required>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
@endsection
