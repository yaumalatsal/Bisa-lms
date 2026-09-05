@section('title-page')
    Inkubasi
@endsection

@extends('dashboard_template/index')
@section('content')
    <div class="container-fluid">
        <div class="row text-center">
            @foreach ($tim as $datatim)
                <h2>Selamat Datang <strong>{{ $datatim->nama_produk }}</strong></h2>
            @endforeach

            <p>Silahkan ikut alur inkubasi dibawah ini, untuk mempermudah anda dalam membangun StartUp yang hebat </p>

        </div>
        <br>
        <div class="row p-30">
            @foreach ($tampilan_tahap as $data)
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-4">
                    @php
                        // Every step stays open — that is deliberate. The status
                        // is shown alongside instead of replacing the button, so
                        // the progress information is not lost.
                        $statusPill = match ((int) ($data->status ?? -1)) {
                            0 => ['Sedang dikerjakan', 'bisa-status--pending'],
                            1 => ['Menunggu validasi', 'bisa-status--neutral'],
                            2 => ['Selesai', 'bisa-status--approved'],
                            3 => ['Perlu revisi', 'bisa-status--rejected'],
                            default => null,
                        };
                    @endphp

                    <div class="card card-step">
                        <div class="card-body">
                            <img src="{{ asset('assets/images/' . $data->gambar) }}"
                                alt="Ilustrasi {{ $data->nama_step }}">
                            <h5 class="card-step__title">{{ $data->step_number }}. {{ $data->nama_step }}</h5>

                            @if ($statusPill)
                                <span class="bisa-status {{ $statusPill[1] }}">{{ $statusPill[0] }}</span>
                            @endif

                            <p class="deskripsi-step">{{ $data->deskripsi }}</p>

                            <a href="{{ url($data->route) }}" class="w-100 btn btn-primary card-step__action">
                                @if ((int) ($data->status ?? -1) === 2)
                                    Lihat <i class="fas fa-arrow-right" aria-hidden="true"></i>
                                @else
                                    Mulai <i class="fas fa-arrow-right" aria-hidden="true"></i>
                                @endif
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Pelatihan Yang Diikuti</h5>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
@endsection
