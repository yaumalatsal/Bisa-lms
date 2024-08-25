@section('title-page')
    Feedback
@endsection

@section('css')
<style>
    /* Gaya untuk modal */
    .modal-dialog{
        max-width: 75%;
    }
    .card-step {
        min-height: 350px;
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    /* Gaya hover pada kartu */
    .card-step:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .card-step .deskripsi-step {
        height: 90px;
    }

    /* Responsivitas untuk perangkat kecil */
    @media (max-width: 420px) {
        .modal-dialog {
            max-width: 100%;
        }
    }

    /* Gaya untuk tabel */
    .table thead {
        background-color: #f8f9fa;
        text-transform: uppercase;
    }

    .table th {
        font-weight: bold;
    }

    .table tbody tr {
        transition: background-color 0.3s ease;
    }

    .table tbody tr:hover {
        background-color: #f1f1f1;
    }

    /* Animasi untuk judul dan konten */
    h3 {
        font-size: 24px;
        font-weight: 700;
        color: #333;
        margin-bottom: 20px;
        animation: fadeInDown 1s ease-in-out;
    }

    p {
        animation: fadeInUp 1s ease-in-out;
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Gaya untuk tombol aksi */
    .btn-warning {
        transition: background-color 0.3s ease;
    }

    .btn-warning:hover {
        background-color: #f39c12;
        color: white;
    }
</style>
@endsection

@extends('dashboard_template/index')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-step">
                <div class="card-body">
                    <div class="row p-4">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3>Feedback</h3>
                                    <p>
                                        Feedback digunakan untuk memberikan saran dan catatan revisi
                                        pada tiap langkah inkubasi dari siswa.
                                    </p>
                                </div>
                            </div>
                            <hr>
                            <br><br>
                            <p>
                                Feedback:
                                <!-- <button class="btn btn-success text-white" data-bs-toggle="modal" data-bs-target="#modalNilai">
                                    <i class="fas fa-plus"></i>&nbsp; Tambah Feedback
                                </button> -->
                            </p>
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-one">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Produk</th>
                                            <th>Topik</th>
                                            <th>Langkah Inkubasi</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 1; @endphp
                                        @foreach($feed as $feedback)
                                        <tr>
                                            <td>{{$no++}}</td>
                                            <td>{{$feedback->nama_produk}}</td>
                                            <td>{{$feedback->judul}}</td>
                                            <td>{{$feedback->nama_step}}</td>
                                            <td>
                                                @if($feedback->status == 0)
                                                    <span class="badge bg-danger">Belum Terkonfirmasi</span>
                                                @else
                                                    <span class="badge bg-success">Terkonfirmasi</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-warning detailFeed" data-bs-toggle="modal" data-bs-target="#modalDetailFeed" data-judulfeed="{{$feedback->judul}}" data-komentarfeed="{{$feedback->komentar}}" data-idfeedback="{{$feedback->id_feedback}}">
                                                    Detail &nbsp;<i class="fas fa-eye"></i>
                                                </button>
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
</div>

<!-- Modal untuk Detail Feedback -->
<div class="modal fade" id="modalDetailFeed">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="ed-pertanyaan">Feedback</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4>Judul: <span id="judul-feed"></span></h4>
                <br>
                <p id="komentar-feed"></p>
            </div>
            <div class="modal-footer">
                <form action="{{url('konfirmFeed')}}" method="post">
                    {{csrf_field()}}
                    <input type="hidden" id="ed-idfeedback" name="id_feed">
                    <button class="btn btn-success" type="submit">Konfirmasi</button>
                    <button class="btn btn-danger" data-bs-dismiss="modal" type="button">Batal</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(function(){
        $(".detailFeed").click(function(){
            var judul_feed = $(this).data('judulfeed');
            var komentar_feed = $(this).data('komentarfeed');
            var id_feed = $(this).data('idfeedback');
            $("#judul-feed").text(judul_feed);
            $("#komentar-feed").text(komentar_feed);
            $("#ed-idfeedback").val(id_feed);
        });
    });
</script>
@endsection
