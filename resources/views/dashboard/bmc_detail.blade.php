@section('title-page')
    Step 3 : Membuat Busines Model Cnvas
@endsection
@section('css')
    <style>
        .modal-dialog{
            max-width:75%;
        }
        .blok-jawaban{
            background-color:#ededed;
            font-size:13px;
            color:#00000;
            padding:15px;            
        }

        .modal-body iframe{
            width:100%;
            height:500px;
        }
        

        @media only screen and (max-width:720px){
            .modal-dialog{
                max-width:100%;
            }         
        }
    </style>
@endsection
@extends('dashboard_template/index')
@section('content')
<div class="container-xl">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                    <div class="col-md-5">
                        @foreach($getmasterbmc as $dataz)
                            <center><img src="{{asset('assets/images/'.$dataz->icon)}}" style="width:40%" class="m-5" alt=""></center>
                        </div>
                        <div class="col-md-6">
                            <h2 class="mt-5"> <strong>{{$dataz->judul}} </strong></h2>
                            <h5>Apa itu {{$dataz->judul}}  ?</h5>
                            <p>{{$dataz->deskripsi}}</p>
                            <a href="{{url('/bmc')}}" class="btn btn-warning text-white"> <i class="fas fa-chevron-left"></i> &nbsp; Kembali ke BMC </a>
                            <button class="btn btn-success text-white" data-bs-toggle="modal" data-bs-target="#materiModal"> <i class="fas fa-play"></i> &nbsp;Video Penjelasan {{$dataz->judul}}  </button>
                        </div>    
                    </div>         
                </div>
            </div>
        <h4>Pertanyaan Terkait {{$dataz->judul}}: </h4>
        @endforeach
            <div class="row">
                @php 
                    $no = 1;
                @endphp
                @foreach($databmc as $bmc)
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h4><strong> {{$no++}}.&nbsp; {{$bmc->pertanyaan}} </strong>
                                &nbsp;&nbsp;
                                <button class="btn btn-info jawab"  data-bs-toggle="modal" data-bs-target="#modalJawaban"
                                     data-pertanyaan="{{$bmc->pertanyaan}}"
                                    data-jawaban="{{$bmc->jawaban}}"
                                    data-idpertanyaan="{{$bmc->id_pertanyaan_bmc}}"
                                    >
                                    Edit Jawaban &nbsp;<i class="fas fa-edit"></i>
                                </button>
                            </h4>
                            <p>Contoh : {{$bmc->keterangan}}</p>
                            <p>Jawaban :</p>
                            <div class="blok-jawaban">
                                    {{$bmc->jawaban}}
                            </div>
                        </div>
                    </div>
                </div>    
                @endforeach
            </div>
        </div>    
    </div>
</div>

<div class="modal fade" id="modalJawaban" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="ed-pertanyaan">pulupulupulu</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{url('/update_jawaban')}}" method="post">
            {{csrf_field()}}  
            <input type="hidden" name="id_pertanyaan" id="ed-idpertanyaan" class="form-control">
            <textarea name="jawaban" id="ed-jawaban" cols="30" rows="10" id="ed-jawaban" class="form-control"></textarea>
            <input type="hidden" name="id_siswa" value="{{Session::get('id_siswa');}}" class="form-control">
            <input type="hidden" name="id_produk" value="{{Session::get('id_produk');}}" class="form-control">
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan Jawaban</button>
            <button type="button"  class="btn btn-danger text-white" data-bs-dismiss="modal">Batalkan</button>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- materi modal -->
<div class="modal fade" id="materiModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <div class="modal-body ytiframe">
            @php echo htmlspecialchars_decode($dataz->video) @endphp
        </div>
        <div class="modal-footer">
            <button type="button"  class="pauseYt btn btn-danger text-white" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

@endsection
@section('js')
<script src="{{asset('assets/js/custom.js')}}"></script>
<script>
    $(function(){
      

        $(".jawab").click(function(){
            var pertanyaan   = $(this).data('pertanyaan');
            var idpertanyaan = $(this).data('idpertanyaan');
            var jawaban = $(this).data('jawaban');
            $('#ed-pertanyaan').text(pertanyaan);
            $('#ed-idpertanyaan').val(idpertanyaan);            
            $('#ed-jawaban').val(jawaban);
        });

        $(".pauseYt").click(function(){
            $(".ytiframe > iframe")[0].contentWindow.postMessage('{"event":"command","func":"' + 'stopVideo' + '","args":""}', '*');
        });
    });
</script>
@endsection
