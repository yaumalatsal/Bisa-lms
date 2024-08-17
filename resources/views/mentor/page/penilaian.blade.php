@section('title-page')
    Dashboard Mentor
@endsection

@section('css')
<style>
    .card-step{
        min-height:350px;
    }
    .card-step .deskripsi-step{
        height:90px;
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
                            <h3>Penilaian Produk  Inkubasi : </h3>
                            <p>Pilih nama produk :</p>
                            <div class="table-responsive">
                                <table class="table table-stripped" id="table-one">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Produk</th>
                                        <th>CEO</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $no =1; @endphp
                                    @foreach($produk as $data)
                                    <tr>
                                        <td>{{$no++}}</td>                            
                                        <td>{{$data->nama_produk}}</td>
                                        <td>{{$data->nama_siswa}}</td>
                                        <td>
                                            <a href="{{url('/mentor/detail_penilaian/'.$data->product_id)}}" class="btn btn-primary">
                                                Beri Penilaian &nbsp;
                                                <i class="fas fa-arrow-circle-right"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    </tbody>
                                    @endforeach
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
    $(function(){
        $("#table-one").DataTable();
    });
</script>
@endsection