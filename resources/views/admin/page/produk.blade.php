@section('title-page')
    Dashboard Admin
@endsection

@section('css')
    <style>
        .card-step {
            min-height: 350px;
        }

        .card-step .deskripsi-step {
            height: 90px;
        }
    </style>
@endsection

@extends('admin/template/index')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row p-4">
                            <div class="col-md-12">
                                <h3>Daftar Produk Inkubasi : </h3>
                                <p>Pilih nama produk :</p>
                                <div class="table-responsive">
                                    <table class="table table-stripped" id="table-one">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Logo</th>
                                                <th>Nama Produk</th>
                                                <th>CEO</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $no =1; @endphp
                                            @foreach ($products as $data)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>
                                                        @if ($data->logo_produk == null)
                                                            <strong>
                                                                <p class="text-danger">Belum Ada Logo</p>
                                                            </strong>
                                                        @else
                                                            <img src="{{ asset('logo_produk/' . $data->logo_produk->logo_produk) }}"
                                                                alt="logo_produk" style="width:100px;">
                                                    </td>
                                            @endif
                                            <td>{{ $data->nama_produk }}</td>
                                            <td>{{ $data->ceo->nama }}</td>
                                            <td>
                                                <a href="{{ route('admin.produk.detail', $data->id) }}"
                                                    class="btn btn-primary">
                                                    Detail Produk &nbsp;
                                                    <i class="fas fa-arrow-circle-right"></i>
                                                </a>
                                                <a href="#" class="btn btn-danger"
                                                    onclick="confirmDelete({{ $data->id }})">
                                                    Hapus Produk &nbsp;
                                                    <i class="fas fa-trash"></i>
                                                </a>

                                                <form id="delete-form-{{ $data->id }}"
                                                    action="{{ route('admin.produk.destroy', $data->id) }}" method="POST"
                                                    style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>

                                            </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
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
@section('js')
    <script>
        $(function() {
            $("#table-one").DataTable();
        });

        function confirmDelete(id) {
            Swal.fire({
                title: 'Apa Yakin Menghapus Produk?',
                text: "Anda Tidak bisa mengulangi lagi!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
@endsection
