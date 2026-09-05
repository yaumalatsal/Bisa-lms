{{--
    Hasil satu poin BMC. Dipakai oleh siswa, mentor, pameran, admin dan
    investor — sebelumnya lima salinan identik dari markup ini.

    Sekarang pertanyaannya ikut ditampilkan, bukan hanya daftar jawaban lepas
    yang tidak jelas menjawab apa.
--}}
@foreach ($getmaster as $masterbmc)
    <div class="card">
        <div class="card-body">
            <h2 class="card-title">{{ $masterbmc->judul }}</h2>
            <p class="card-subtitle">{{ $masterbmc->deskripsi }}</p>
        </div>
    </div>
@endforeach

<div class="card">
    <div class="card-body">
        @forelse ($getResult as $bmc)
            <div @class(['mb-4' => ! $loop->last])>
                <h3 class="h6 text-muted mb-1">{{ $bmc->pertanyaan ?? 'Jawaban' }}</h3>
                <p class="mb-0">{{ $bmc->jawaban ?: '—' }}</p>
            </div>
        @empty
            <div class="bisa-empty">
                <i class="mdi mdi-clipboard-text-outline bisa-empty__icon" aria-hidden="true"></i>
                <p class="bisa-empty__title">Belum ada jawaban</p>
                <p class="bisa-empty__body">Tim belum mengisi poin BMC ini.</p>
            </div>
        @endforelse
    </div>
</div>

<a href="{{ url()->previous() }}" class="btn btn-secondary">
    <i class="mdi mdi-chevron-left" aria-hidden="true"></i> Kembali
</a>
