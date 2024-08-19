@section('title-page')
    Dashboard Investor
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

@extends('investor/template/index')
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
                                    @foreach($products as $data)
                                    <tr>
                                        <td>{{$no++}}</td>
                                        <td>
                                            @if($data->logo_produk == NULL )
                                            <strong>
                                                <p class="text-danger">Belum Ada Logo</p>
                                            </strong>
                                            @else
                                            <img src="{{asset('logo_produk/'.$data->logo_produk->logo_produk)}}" alt="logo_produk" style="width:100px;"></td>
                                            @endif
                                        <td>{{$data->nama_produk}}</td>
                                        <td>{{$data->ceo->nama}}</td>
                                        <td>
                                            <a href="{{ route('investor.produk.detail',$data->id) }}" class="btn btn-primary">
                                                Detail Produk &nbsp;
                                                <i class="fas fa-arrow-circle-right"></i>
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