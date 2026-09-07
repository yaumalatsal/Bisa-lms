{{--
    Detail produk — satu implementasi untuk siswa, mentor, pameran mentor,
    admin dan investor. Sebelumnya empat salinan identik dari ~330 baris ini.

    Parameter:
      $bmcRoute      string  nama route detail BMC (menerima id_bmc + id_produk)
      $canEditTrack  bool    tampilkan tombol "Ubah Progress" (mentor saja)

    Data berasal dari App\Services\ProductDetailService::forProduct().

    Perbaikan dibanding versi lama:
      - tab Pitch Deck menautkan deck, bukan link Figma milik tab Prototype;
      - tombol "Ubah Progress" bekerja pada semua baris, bukan hanya baris
        pertama (dulu memakai id yang sama berulang kali);
      - video produk tidak lagi di-echo sebagai HTML mentah;
      - blok @media punya sintaks yang valid sehingga gaya mobile benar-benar
        diterapkan.
--}}
@php
    use App\Support\Embed;

    $bmcRoute = $bmcRoute ?? null;
    $canEditTrack = $canEditTrack ?? false;

    $produkUtama = $produk->first();

    $positions = [1 => 'Hustler (CEO)', 2 => 'Hipster', 3 => 'Hacker'];

    // status track_step -> [label, kelas pil]
    $trackStatus = [
        0 => ['Proses pengembangan', 'bisa-status--pending'],
        1 => ['Menunggu validasi mentor', 'bisa-status--neutral'],
        2 => ['Selesai', 'bisa-status--approved'],
        3 => ['Revisi dari mentor', 'bisa-status--rejected'],
    ];
@endphp

@unless ($produkUtama)
    <div class="card">
        <div class="bisa-empty">
            <i class="mdi mdi-package-variant bisa-empty__icon" aria-hidden="true"></i>
            <p class="bisa-empty__title">Produk tidak ditemukan</p>
            <p class="bisa-empty__body">Produk ini tidak ada, atau Anda tidak punya akses ke sana.</p>
        </div>
    </div>
@else
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="card-title">{{ $produkUtama->nama_produk }}</h2>
                    <p class="card-subtitle mb-4">
                        Mentor pendamping: <strong>{{ $produkUtama->nama_mentor }}</strong>
                    </p>

                    <h3 class="h6 text-muted">Anggota tim</h3>
                    <ul class="list-unstyled mb-0">
                        @foreach ($member as $anggota)
                            <li class="d-flex align-items-center gap-2 mb-2">
                                <span class="bisa-status bisa-status--neutral">
                                    {{ $anggota->posisi ?? $positions[(int) $anggota->position] ?? 'Anggota' }}
                                </span>
                                <strong>{{ $anggota->nama }}</strong>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="col-md-4 text-center">
                    @if ($produkUtama->logo_produk)
                        <img src="{{ asset('logo_produk/' . $produkUtama->logo_produk) }}"
                            alt="Logo {{ $produkUtama->nama_produk }}" style="max-width:200px">
                    @else
                        <div class="bisa-empty py-4">
                            <i class="mdi mdi-image bisa-empty__icon" aria-hidden="true"></i>
                            <p class="mb-0">Belum ada logo</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Progress Inkubasi</h2>
        </div>
        <div class="card-body">
            @forelse ($track as $tahap)
                @php([$statusLabel, $statusClass] = $trackStatus[(int) $tahap->status] ?? ['Tidak diketahui', 'bisa-status--neutral'])
                <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap {{ $loop->last ? '' : 'mb-3 pb-3 border-bottom' }}">
                    <div>
                        <strong>{{ $tahap->step_number }}. {{ $tahap->nama_step }}</strong>
                        <span class="bisa-status {{ $statusClass }} ms-2">{{ $statusLabel }}</span>
                    </div>

                    @if ($canEditTrack)
                        {{-- data-* per baris; dulu setiap tombol memakai id yang
                             sama sehingga hanya baris pertama yang berfungsi. --}}
                        <button type="button" class="btn btn-sm btn-primary js-ubah-progress"
                            data-bs-toggle="modal" data-bs-target="#trackModal"
                            data-track="{{ $tahap->id_track }}" data-idproduk="{{ $tahap->id_produk }}">
                            <i class="mdi mdi-pencil" aria-hidden="true"></i> Ubah Progress
                        </button>
                    @endif
                </div>
            @empty
                <p class="text-muted mb-0">Belum ada tahapan yang tercatat.</p>
            @endforelse
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Kelengkapan Produk</h2>
        </div>
        <div class="card-body">
            <nav>
                <div class="nav nav-tabs" id="produk-tab" role="tablist">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-abstrak"
                        type="button" role="tab" aria-controls="tab-abstrak" aria-selected="true">Abstrak</button>
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-bmc"
                        type="button" role="tab" aria-controls="tab-bmc" aria-selected="false">Business Model Canvas</button>
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-proto"
                        type="button" role="tab" aria-controls="tab-proto" aria-selected="false">Prototype</button>
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-logo"
                        type="button" role="tab" aria-controls="tab-logo" aria-selected="false">Logo</button>
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-video"
                        type="button" role="tab" aria-controls="tab-video" aria-selected="false">Video</button>
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-poster"
                        type="button" role="tab" aria-controls="tab-poster" aria-selected="false">Poster</button>
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-deck"
                        type="button" role="tab" aria-controls="tab-deck" aria-selected="false">Pitch Deck</button>
                </div>
            </nav>

            <div class="tab-content pt-4">
                <div class="tab-pane fade show active" id="tab-abstrak" role="tabpanel">
                    <h3 class="h5">{{ $produkUtama->nama_produk }}</h3>
                    <p class="mb-0">{{ $produkUtama->deskripsi }}</p>
                </div>

                <div class="tab-pane fade" id="tab-bmc" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col" style="width:4rem">No</th>
                                    <th scope="col">Poin BMC</th>
                                    <th scope="col" class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bmc as $databmc)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $databmc->judul }}</td>
                                        <td class="text-end">
                                            @if ($bmcRoute)
                                                <a class="btn btn-sm btn-secondary"
                                                    href="{{ route($bmcRoute, [$databmc->id, $produkUtama->product_id]) }}">
                                                    <i class="mdi mdi-eye" aria-hidden="true"></i> Detail
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="tab-proto" role="tabpanel">
                    @forelse ($proto as $figma)
                        @php($url = Embed::safeUrl($figma->link_figma))
                        @if ($url)
                            <a href="{{ $url }}" target="_blank" rel="noopener noreferrer"
                                class="d-block mb-2">{{ $figma->link_figma }}</a>
                        @else
                            <p class="mb-2">{{ $figma->link_figma }}</p>
                        @endif
                    @empty
                        <p class="text-muted mb-0">Belum ada link prototype.</p>
                    @endforelse
                </div>

                <div class="tab-pane fade" id="tab-logo" role="tabpanel">
                    @forelse ($logo as $logos)
                        <figure class="text-center">
                            <img src="{{ asset('logo_produk/' . $logos->logo_produk) }}"
                                alt="Logo produk" style="max-width:220px">
                            <figcaption class="text-muted mt-3">{{ $logos->deskripsi }}</figcaption>
                        </figure>
                    @empty
                        <p class="text-muted mb-0">Belum ada logo.</p>
                    @endforelse
                </div>

                <div class="tab-pane fade" id="tab-video" role="tabpanel">
                    @forelse ($video as $videos)
                        @php($embed = Embed::youtubeEmbedUrl($videos->link_video))
                        @if ($embed)
                            <div class="ratio ratio-16x9 mb-3" style="max-width:720px">
                                <iframe src="{{ $embed }}" title="Video produk"
                                    allow="accelerometer; encrypted-media; picture-in-picture"
                                    referrerpolicy="strict-origin-when-cross-origin"
                                    allowfullscreen loading="lazy"></iframe>
                            </div>
                        @elseif ($url = Embed::safeUrl($videos->link_video))
                            <a href="{{ $url }}" target="_blank" rel="noopener noreferrer">{{ $url }}</a>
                        @else
                            <p class="text-muted mb-0">Link video tidak dikenali.</p>
                        @endif
                    @empty
                        <p class="text-muted mb-0">Belum ada video produk.</p>
                    @endforelse
                </div>

                <div class="tab-pane fade" id="tab-poster" role="tabpanel">
                    @forelse ($poster as $posters)
                        <img src="{{ asset('poster_produk/' . $posters->poster_produk) }}"
                            alt="Poster produk" class="mb-3" style="max-width:600px">
                    @empty
                        <p class="text-muted mb-0">Belum ada poster.</p>
                    @endforelse
                </div>

                <div class="tab-pane fade" id="tab-deck" role="tabpanel">
                    @forelse ($presentasi as $deck)
                        {{-- Dulu menautkan $figma->link_figma yang bocor dari tab Prototype. --}}
                        @php($url = Embed::safeUrl($deck->deck))
                        @if ($url)
                            <a href="{{ $url }}" target="_blank" rel="noopener noreferrer"
                                class="d-block mb-2">{{ $deck->deck }}</a>
                        @else
                            <p class="mb-2">{{ $deck->deck }}</p>
                        @endif
                    @empty
                        <p class="text-muted mb-0">Belum ada pitch deck.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @if ($canEditTrack)
        <div class="modal fade" id="trackModal" tabindex="-1" aria-labelledby="trackModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{ url('/mentor/editTrack') }}" method="post">
                        @csrf
                        <div class="modal-header">
                            <h2 class="modal-title" id="trackModalLabel">Ubah Progress Inkubasi</h2>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>

                        <div class="modal-body">
                            <input type="hidden" name="id_produk" id="ed-id-produk">
                            <input type="hidden" name="id_track" id="ed-id-track">

                            <div class="form-group">
                                <label class="form-label" for="ed-step">Langkah Inkubasi</label>
                                <select name="step" id="ed-step" class="form-control">
                                    @foreach ($masterstep as $step)
                                        <option value="{{ $step->id }}">{{ $step->nama_step }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="ed-status">Status Progress</label>
                                <select name="status" id="ed-status" class="form-control">
                                    <option value="0">OPEN — acc dan buka tahap berikutnya</option>
                                    <option value="3">REVISI — kembalikan dengan feedback</option>
                                    <option value="2">ACC — acc tanpa membuka tahap berikutnya</option>
                                </select>
                            </div>

                            <div id="feedback-fields" hidden>
                                <div class="form-group">
                                    <label class="form-label" for="ed-judul">Judul Feedback</label>
                                    <input type="text" class="form-control" id="ed-judul" name="judul_feedback">
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="ed-feedback">Feedback Mentor</label>
                                    <textarea class="form-control" id="ed-feedback" name="feedback" rows="6"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @push('scripts')
            <script>
                (function () {
                    var status = document.getElementById('ed-status');
                    var feedback = document.getElementById('feedback-fields');

                    function syncFeedback() {
                        feedback.hidden = status.value !== '3';
                    }

                    status.addEventListener('change', syncFeedback);
                    syncFeedback();

                    // Delegated: every row's button works, not just the first.
                    document.addEventListener('click', function (event) {
                        var button = event.target.closest('.js-ubah-progress');
                        if (!button) {
                            return;
                        }
                        document.getElementById('ed-id-produk').value = button.dataset.idproduk || '';
                        document.getElementById('ed-id-track').value = button.dataset.track || '';
                    });
                })();
            </script>
        @endpush
    @endif
@endunless
