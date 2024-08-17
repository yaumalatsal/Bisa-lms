@section('title-page')
    Penilaian  Mentor
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
                            
                            <h3>Riwayat Penilaian </h3> 
                            <div class="table-responsive">
                                <table class="table table-stripped" id="table-one">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Langkah</th>
                                        <th>File Penilaian</th>
                                        
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


@endsection
@section('js')
<script>
    $(function(){
        // $("#table-one").DataTable();
        
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