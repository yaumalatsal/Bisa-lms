{{--
    Halaman ini sebelumnya berisi konten demo bawaan tema — "Angular Project /
    Albert Cook" beserta avatar contoh — dan sama sekali tidak menggunakan
    $rankings. Sekarang datanya nyata.

    Catatan: tabel `rankings` tidak punya UI untuk mengisinya dan tidak tertaut
    dari menu mana pun. Peringkat yang dipakai siswa ada di /peringkat dan
    /points. Pertimbangkan untuk menghapus fitur ini bila memang tidak terpakai.
--}}
@extends('dashboard_template.index')

@section('title-page', 'Ranking')
@section('page-subtitle', 'Daftar peringkat berdasarkan skor.')

@section('content')
    <div class="card">
        <div class="table-responsive">
            <table class="table" id="table-ranking">
                <thead>
                    <tr>
                        <th scope="col" style="width:5rem">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col" class="text-end">Skor</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rankings as $ranking)
                        <tr>
                            <td class="bisa-numeric">{{ $loop->iteration }}</td>
                            <th scope="row" class="fw-semibold">{{ $ranking->name }}</th>
                            <td class="text-end bisa-numeric">{{ number_format($ranking->score) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">
                                <div class="bisa-empty">
                                    <i class="mdi mdi-trophy-outline bisa-empty__icon" aria-hidden="true"></i>
                                    <p class="bisa-empty__title">Belum ada data peringkat</p>
                                    <p class="bisa-empty__body">Peringkat kuis tersedia di menu Ranking Quiz.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
