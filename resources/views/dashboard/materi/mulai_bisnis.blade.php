<!-- File: resources/views/admin/materi/bmc.blade.php -->

@extends('admin.template.index')

@section('title-page')
    Materi Kategori BMC
@endsection

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Materi Kategori BMC</h1>

        <!-- Artikel Section -->
        <h2>Artikel</h2>
        @if($artikel->isEmpty())
            <p>Belum ada artikel di kategori ini.</p>
        @else
            <div class="list-group">
                @foreach($artikel as $item)
                    <div class="list-group-item">
                        <h5>{{ $item->judul }}</h5>
                        <a href="{{ $item->link }}" class="btn btn-primary" target="_blank">Pelajari Lebih Lanjut</a>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Video Section -->
        <h2 class="mt-4">Video</h2>
        @if($video->isEmpty())
            <p>Belum ada video di kategori ini.</p>
        @else
            <div class="list-group">
                @foreach($video as $item)
                    <div class="list-group-item">
                        <h5>{{ $item->judul }}</h5>
                        <a href="{{ $item->link }}" class="btn btn-primary" target="_blank">Pelajari Lebih Lanjut</a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
