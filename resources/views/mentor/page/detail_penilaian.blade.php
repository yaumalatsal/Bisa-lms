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

    @media(max-width:420px){
        .modal-dialog{
            max-width:100%;
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
                            <a href="{{url('mentor/penilaian')}}" class="btn btn-warning">
                                <i class="fas fa-chevron-left"></i>
                                &nbsp;
                                Kembali ke Daftar Produk
                            </a>

                            <br><br>
                            @foreach($produk as $data)
                            <div class="row">
                                <div class="col-md-6">
                                    <h3>{{$data->nama_produk}} </h3>
                                    <p>
                                        <ul>
                                            <li>Nama CEO : {{$data->nama_siswa}}</li>
                                            <li>Deskripsi : {{$data->deskripsi}}</li>
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

                            <hr>
                            <br><br>
                            <p>
                                Riwayat Penilaian : 
                                <button class="btn btn-success text-white" data-bs-toggle="modal" data-bs-target="#modalNilai">
                                    <i class="fas fa-plus"></i>&nbsp; Tambah Penilaian
                                </button>
                            </p>
                            <div class="table-responsive">
                                <table class="table table-stripped" id="table-one">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Langkah</th>
                                        <th>File Penilaian</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 1; @endphp
                                        @foreach($nilai as $datanilai)
                                        <tr>
                                            <td>{{$no++}}</td>
                                            <td>{{$datanilai->nama_step}}</td>
                                            <td>
                                                <a href="{{$datanilai->file_nilai}}" target="_blank">
                                                    {{$datanilai->file_nilai}}
                                                </a>
                                            </td>
                                            <td>
                                                <button class="btn btn-warning editNilai" data-bs-toggle="modal" data-bs-target="#modalEditNilai" data-file="{{$datanilai->file_nilai}}" data-langkah="{{$datanilai->nama_step}}" data-idpenilaian="{{$datanilai->penilaian_id}}" data-idstep="{{$datanilai->id_step}}"> <i class="fas fa-edit"> </i></button>
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
<!-- modal input nilai-->
<div class="modal fade" id="modalNilai">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="ed-pertanyaan">Penilaian</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-warning">
            <p>
                <i class="fas fa-exclamation-circle"></i> Format penilaian setiap langkah menyesuaikan dengan parameter dari tiap mentor.
                Link yang diupload adalah link file penilaian yang telah di simpan di dalam Google Drive
                atau Drive penyimpanan lain
            </p>
        </div>
        <form action="{{url('/mentor/inputNilai')}}" method="post" enctype='multipart/form-data'>
            {{csrf_field()}}   
            <label for="">Langkah Inkubasi</label>
            <select name="step" class="form-control">
                @foreach($masterstep as $step)
                <option value="{{$step->id}}">{{$step->step_number}}. {{$step->nama_step}}</option>
                @endforeach
            </select>

            <br>
            <label for="">Link File Penilaian</label>
            <input type="text" class="form-control" name="nilai">
            <input type="hidden" name="id_produk" value="{{$data->product_id}}">
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button"  class="btn btn-danger text-white" data-bs-dismiss="modal">Batalkan</button>
            </div>
        </form>
        </div>
    </div>
  </div>
</div>
<!-- end of modal input nilai -->
<div class="modal fade" id="modalEditNilai">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="ed-pertanyaan">Penilaian</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{url('/mentor/editNilai')}}" method="post" enctype='multipart/form-data'>
            {{csrf_field()}}   
            <label for="">Langkah Inkubasi</label>
            <input type="text" readonly value="" class="form-control" id="ed-nama-step" >
            <input type="hidden" value=""  name="id_step" id="ed-id-step">
            <input type="hidden" value="" name="id_penilaian" id="ed-id-penilaian">

            <br>
            <label for="">Link File Penilaian</label>
            <input type="text" class="form-control" id="ed-nilai" name="nilai">
            <input type="hidden" name="id_produk" value="{{$data->product_id}}">
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
    });

    
</script>
@endsection