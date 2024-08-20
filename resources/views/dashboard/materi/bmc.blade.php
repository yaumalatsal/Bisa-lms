<!-- File: resources/views/admin/materi/bmc.blade.php -->

@extends('dashboard_template.index')

@section('title-page')
    Materi Kategori BMC
@endsection

@section('content')
<style>
    /* File: public/css/styles.css atau di dalam <style> di view */
.card-img-top {
    object-fit: cover;
    width: 100%;
    height: 200px; /* Ubah tinggi sesuai dengan kebutuhan untuk rasio 4:3 */
}
</style>
    <div class="container mt-4">
        {{-- <h1 class="mb-4">Materi Kategori BMC</h1> --}}

        <!-- Artikel Section -->
        <h2>Artikel</h2>
        @if($artikel->isEmpty())
            <p>Belum ada artikel di kategori ini.</p>
        @else
            <div class="row">
                @foreach($artikel as $item)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="{{ asset('storage/' . $item->thumbnail) }}" class="card-img-top img-thumbnail" alt="{{ $item->judul }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->judul }}</h5>
                                <a href="{{ $item->link }}" class="btn btn-primary" target="_blank">Pelajari Lebih Lanjut</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Video Section -->
        <h2 class="mt-4">Video</h2>
        @if($video->isEmpty())
            <p>Belum ada video di kategori ini.</p>
        @else
            <div class="row">
                @foreach($video as $item)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="{{ asset('storage/' . $item->thumbnail) }}" class="card-img-top img-thumbnail" alt="{{ $item->judul }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->judul }}</h5>
                                <a href="{{ $item->link }}" class="btn btn-primary" target="_blank">Pelajari Lebih Lanjut</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
