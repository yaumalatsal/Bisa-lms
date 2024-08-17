@section('title-page')
    Dashboard Mentor
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
    #poster_produk img{
            width:400px;
    }

    @media(max-width:420px;){

        .nav-link{
            width:100%;
        }
        .modal-dialog{
            max-width:100%;
        }

        #logo-produk{
            width:80%;
            margin-bottom:20px;
            margin-top:20px;
        }

        #video_produk iframe{
            width:100%;
        }

        
        #poster_produk img{
            width:100%;
        }
    }
</style>
@endsection

@extends('mentor/template/index')
@section('content')
<div class="container-fluid">
<div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row p-4">
                        <div class="col-md-12">
                            @foreach($produk as $data)
                            <div class="row">
                                <div class="col-md-6">
                                    <h3>{{$data->nama_produk}} </h3>    
                                    <p>
                                        Anggota : <br>
                                        <ul>
                                            @foreach($member as $anggota)
                                            <li>
                                                @if($anggota->position == '1')
                                                Hustler (CEO) &nbsp;:
                                                @elseif($anggota->position == '2')
                                                Hipster &nbsp;:
                                                @else
                                                Hacker &nbsp;:
                                                @endif
                                                <strong>{{$anggota->nama}}</strong>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <center>
                                        @if($data->logo_produk == NULL)
                                            <h2 class="mt-5 text-warning">
                                                <i class="fas fa-file-image"></i>
                                                Belum Ada Logo
                                            </h2>
                                        @else
                                        <img src="{{asset('logo_produk/'.$data->logo_produk)}}" class="mt-5" style="width:200px;" alt="">
                                        @endif
                                    </center>
                                </div>
                            </div>
                            @endforeach

                            <p>Progress Terakhir :</p>
                            @foreach($track as $tahap)
                            <div class="alert 
                                        @if($tahap->status == 0)
                                            alert-warning
                                        @elseif($tahap->status == 2)
                                            alert-success
                                        @elseif($tahap->status ==  1)
                                            alert-danger
                                        @elseif($tahap->status ==  3)
                                            alert-warning
                                        @endif 
                            row">
                                <div class="col-md-6">
                                    <p class="mt-2"><strong>{{$tahap->step_number}}.&nbsp;{{$tahap->nama_step}}            </strong> 
                                        : 
                                        @if($tahap->status == 0)
                                            Proses Pengembangan
                                        @elseif($tahap->status == 2)
                                            Selesai
                                        @elseif($tahap->status ==  1)
                                            Menunggu Validasi Mentor                     
                                        @elseif($tahap->status ==  3)
                                            Revisi dari mentor
                                        @endif 
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <button id="ubahProgress" data-bs-toggle="modal" data-bs-target="#trackModal" class="btn btn-success text-white float-end" data-track="{{$tahap->id_track}}" data-idproduk="{{$tahap->id_produk}}">Ubah Progress <i class="fa fa-edit"></i></button>
                                </div>
                            </div>
                            @endforeach
                            <hr>
                        </div>
                    </div>    
                    
                    <div class="row p-4 pt-0">
                        <div class="col-md-12">
                            <h3>Kelengkapan Produk : </h3>
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#abstrak" type="button" role="tab" aria-controls="nav-abstrak" aria-selected="true">Abstrak Produk</button>
                                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#bmc" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Business Model Canvas</button>
                                    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#figma" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Prototype</button>
                                    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#logo" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Logo</button>
                                    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#video_produk" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Video Produk</button>
                                    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#poster_produk" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Poster</button>
                                    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#deck" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Pitch Deck</button>
                                </div>
                            </nav>
                            <div class="tab-content">
                                <div class="tab-pane fade show p-3 active" id="abstrak" role="tabpanel" aria-labelledby="abstrak-tab">
                                   <br>
                                    @foreach($produk as $dataproduk)
                                    <h3>{{$dataproduk->nama_produk}}</h3>
                                    <p>{{$dataproduk->deskripsi}}</p>
                                    @endforeach
                                </div>

                                <div class="tab-pane fade p-3" id="bmc" role="tabpanel" aria-labelledby="bmc-tab">
                                    <br>
                                    <h3>Business Model Canvas :</h3>
                                    
                                    <div class="table-responsive">
                                        <table class="table table-stripped">
                                            <tr>
                                                <td>No</td>
                                                <td colspan="2">Poin BMC</td>
                                            </tr>
                                        
                                        @php $nourut = 1; @endphp
                                        @foreach($bmc as $databmc)
                                            <tr>
                                                <td>{{$nourut++}}</td>
                                                <td>{{$databmc->judul}}</td>
                                                <td>
                                                    <a href="{{url('/mentor/detail_result_bmc/'.$databmc->id.'/'.$data->product_id)}}" class="btn btn-primary">
                                                        Detail &nbsp;<span class="fas fa-eye"></span>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </table>
                                    </div>

                                </div>

                                <div class="tab-pane fade p-3" id="figma" role="tabpanel" aria-labelledby="bmc-tab">
                                    <br>
                                    <h3>Prototype Produk</h3>
                                    <p>berikut adalah link prototype produk :</p>
                                    @foreach($proto as $figma)
                                    <a href="{{$figma->link_figma}}">
                                        <div class="alert alert-success">
                                        {{$figma->link_figma}}
                                        </div>
                                    </a>
                                    @endforeach
                                </div>
                                
                                <div class="tab-pane fade p-3" id="logo" role="tabpanel" aria-labelledby="bmc-tab">
                                    <br>
                                    <h3>Logo Produk</h3>
                                    <p>berikut adalah logo dari produk :</p>
                                    @foreach($logo as $logos)
                                    <center>
                                        <img id="logo-produk" src="{{asset('logo_produk/'.$logos->logo_produk)}}" alt="" style="width:200px">
                                    </center>
                                    <p>
                                        {{$logos->deskripsi}}
                                    </p>
                                    @endforeach
                                </div>

                                <div class="tab-pane fade p-3" id="video_produk" role="tabpanel" aria-labelledby="bmc-tab">
                                    <br>
                                    <h3>Video Produk</h3>
                                    <p>berikut adalah video dari produk :</p>
                                    @foreach($video as $videos)
                                    @php 
                                        echo htmlspecialchars_decode($videos->link_video);
                                    @endphp
                                    @endforeach
                                </div>

                                <div class="tab-pane fade p-3" id="poster_produk" role="tabpanel" aria-labelledby="bmc-tab">
                                    <br>
                                    <h3>Poster Produk</h3>
                                    <p>berikut adalah poster dari produk :</p>
                                    @foreach($poster as $posters)
                                    <img src="{{asset('poster_produk/'.$posters->poster_produk)}}" alt="">
                                    @endforeach
                                </div>

                                <div class="tab-pane fade p-3" id="deck" role="tabpanel" aria-labelledby="bmc-tab">
                                    <br>
                                    <h3>Pitch Deck</h3>
                                    <p>berikut adalah link slide pith deck produk :</p>
                                    @foreach($presentasi as $deck)
                                    <a href="{{$figma->link_figma}}">
                                        <div class="alert alert-success">
                                        {{$deck->deck}}
                                        </div>
                                    </a>
                                    @endforeach
                                </div>
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
<div class="modal fade" id="trackModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="ed-pertanyaan">Penilaian</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{url('/mentor/editTrack')}}" method="post" enctype='multipart/form-data'>
            {{csrf_field()}}   
            <label for="">Langkah Inkubasi</label>
            <select name="step" class="form-control">
                @foreach($masterstep as $step)
                <option value="{{$step->id}}">{{$step->nama_step}}</option>
                @endforeach
            </select>
            <input type="hidden" value="" name="id_produk" id="ed-id-produk">
            <input type="hidden" value="" name="id_track" id="ed-id-track">
            <br>
            <label for="">Status Progress</label>
            <select name="status" id="status" class="form-control">
                <option value="0">OPEN (Acc dan Membuka proses  inkubasi selanjutnya)</option>
                <option value="3">REVISI (Revisi dan Memberi Feedback )</option>
                <option value="2">ACC (Acc tahap tanpa Membuka proses  inkubasi selanjutnya)</option>
            </select>
            <div id="feedback">
                <br>
                <label for="">Judul</label>
                <input type="text" class="form-control" name="judul_feedback">
                <br>
                <label for="">Feedback Mentor</label>
                <textarea class="form-control" id="" name="feedback" cols="30" rows="10"></textarea>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button"  class="btn btn-danger text-white" data-bs-dismiss="modal">Batalkan</button>
            </div>
        </form>
        </div>
    </div>
  </div>
</div>
@endsection
@section('js')
<script>
    $(function(){
        $("#table-one").DataTable();
        
        $(".editNilai").click(function(){
            var id_step = $(this).data('idstep');
            var langkah = $(this).data('langkah');
            var namafile = $(this).data('file');
            var id_penilaian = $(this).data('idpenilaian')

            $("#ed-nama-step").val(langkah);
            $("#ed-id-step").val(id_step);
            $("#ed-nilai").val(namafile);
            $("#ed-id-penilaian").val(id_penilaian);
        });

        $("#feedback").hide();
        $("#status").change(function(){
            var status = $("#status").val();
            if(status == '3'){
                $("#feedback").show();
            }else{
                $("#feedback").hide();
            }
        });


        $("#ubahProgress").click(function(){
            var track = $(this).data('track');
            var idproduk = $(this).data('idproduk');
            $("#ed-id-produk").val(idproduk);
            $("#ed-id-track").val(track);
        });
    });

    
</script>
@endsection