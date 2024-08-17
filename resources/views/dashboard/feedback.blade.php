@section('title-page')
    Feedback
@endsection

@section('css')
<style>
      .modal-dialog{
            max-width:75%;
    }
    .card-step{
        min-height:350px;
    }
    .card-step .deskripsi-step{
        height:90px;
    }

    @media(max-width:420px){
        .modal-dialog{
            max-width:100%;
         }   
    }
</style>
@endsection

@extends('dashboard_template/index')
@section('content')
<div class="container-fluid">
<div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row p-4">
                        <div class="col-md-12">

                            <div class="row">
                                <div class="col-md-6">
                                    <h3>Feedback</h3>
                                    <p>
                                        Feedback digunakan untuk memberikan saran dan catatan revisi
                                        pada tiap  langkah inkubasi dari siswa.
                                    </p>
                                </div>

                            <hr>
                            <br><br>
                            <p>
                                Feedback : 
                                <!-- <button class="btn btn-success text-white" data-bs-toggle="modal" data-bs-target="#modalNilai">
                                    <i class="fas fa-plus"></i>&nbsp; Tambah Feeedback
                                </button> -->
                            </p>
                            <div class="table-responsive">
                                <table class="table table-stripped" id="table-one">
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
                                            <td>
                                                {{$feedback->judul}}
                                            </td>
                                            <td>{{$feedback->nama_step}}</td>
                                            <td>
                                                @if($feedback->status == 0)
                                                    <span class="badge bg-danger">Belum Terkonfirmasi</span>
                                                @else
                                                    <span class="badge bg-success">Terkonfirmasi</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-warning detailFeed" data-bs-toggle="modal" data-bs-target="#modalDetailFeed" data-judulfeed="{{$feedback->judul}}" data-komentarfeed="{{$feedback->komentar}}" data-idfeedback="{{$feedback->id_feedback}}"> Detail &nbsp;<i class="fas fa-eye"> </i></button>
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

<!-- end of modal input nilai -->
<div class="modal fade" id="modalDetailFeed">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="ed-pertanyaan">Feedback</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
         <div class="modal-body">
            <h4>Judul : <span id="judul-feed"></span></h4>
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