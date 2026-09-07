@section('title-page')
    Step 3 : Membuat Busines Model Cnvas
@endsection
@section('css')
    <style>
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
                            <div class="text-center"><img src="{{asset('assets/images/'.$dataz->icon)}}" style="width:40%" class="m-5" alt=""></div>
                        </div>
                        <div class="col-md-6">
                            <h2 class="mt-5"> <strong>{{$dataz->judul}} </strong></h2>
                            <h5>Apa itu {{$dataz->judul}}  ?</h5>
                            <p>{{$dataz->deskripsi}}</p>
                            <a href="{{url('/bmc')}}" class="btn btn-secondary"> <i class="fas fa-chevron-left"></i> &nbsp; Kembali ke BMC </a>
                            <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#materiModal"> <i class="fas fa-play"></i> &nbsp;Video Penjelasan {{$dataz->judul}}  </button>
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
                                <button class="btn btn-primary jawab"  data-bs-toggle="modal" data-bs-target="#modalJawaban"
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

{{-- The form opened in .modal-body and closed after .modal-footer, so the
     parsed document put the submit button outside the form. It now wraps the
     dialog. The heading placeholder ("pulupulupulu") is filled in by the JS
     that opens the modal. --}}
<div class="modal fade" id="modalJawaban" tabindex="-1" aria-labelledby="modalJawabanTitle" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ url('/update_jawaban') }}" method="post">
        @csrf

        <div class="modal-header">
          <h3 class="modal-title" id="modalJawabanTitle">Jawaban</h3>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="id_pertanyaan" id="ed-idpertanyaan">
          <label class="form-label" for="ed-jawaban">Jawaban Anda</label>
          <textarea name="jawaban" id="ed-jawaban" rows="10" class="form-control"></textarea>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
          <button type="submit" class="btn btn-primary">Simpan Jawaban</button>
        </div>
      </form>
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
            {{-- The `video` column stores a pasted <iframe>. Echoing it as raw
                 HTML made every stored value executable markup; we extract the
                 video id and build the embed ourselves instead. --}}
            @php($materiVideo = \App\Support\Embed::youtubeEmbedUrl($dataz->video ?? null))
            @if ($materiVideo)
                <div class="ratio ratio-16x9">
                    <iframe src="{{ $materiVideo }}" title="Video penjelasan {{ $dataz->judul }}"
                        allow="accelerometer; encrypted-media; picture-in-picture"
                        referrerpolicy="strict-origin-when-cross-origin"
                        allowfullscreen loading="lazy"></iframe>
                </div>
            @else
                <p class="text-muted mb-0">Belum ada video penjelasan untuk poin ini.</p>
            @endif
        </div>
        <div class="modal-footer">
            <button type="button"  class="pauseYt btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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
            $('#modalJawabanTitle').text(pertanyaan);
            $('#ed-idpertanyaan').val(idpertanyaan);            
            $('#ed-jawaban').val(jawaban);
        });

        $(".pauseYt").click(function(){
            $(".ytiframe > iframe")[0].contentWindow.postMessage('{"event":"command","func":"' + 'stopVideo' + '","args":""}', '*');
        });
    });
</script>
@endsection
