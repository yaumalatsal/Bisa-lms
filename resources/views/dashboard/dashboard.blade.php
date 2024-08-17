@section('title-page')
    Dashboard
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

@extends('dashboard_template/index')
@section('content')
<div class="container-fluid">
    <div class="row text-center">
            @foreach($tim as $datatim)
                <h2>Selamat Datang  <strong>{{$datatim->nama_produk}}</strong></h2>
            @endforeach

            <p>Silahkan ikuti alur inkubasi dibawah ini, untuk mempermudah anda dalam membangun StartUp yang hebat </p>
        
    </div>    
    <br>
    <div class="row p-30">
        @foreach($tampilan_tahap as $data)
        <div class="col-md-2 col-sm-4">
            <div class="card card-step">
                <div class="card-body">
                    <img src="{{asset('assets/images/'.$data->gambar)}}" alt="" class="w-50 mt-2">
                    <h5 class="mt-3" ><br>{{$data->nama_step}} </h5>
                    <p class="deskripsi-step">{{$data->deskripsi}} </p>
                    @if($data->status == '' || $data->status == 2)
                        <a href="#" class="w-100 btn btn-info text-white"><i class="fas fa-check-circle"></i> SELESAI</a>
                    @elseif($data->status == 1)
                    <a href="#" class="w-100 btn btn-success text-white"><i class="fas fa-edit"></i> PROSES VALIDASI</a>
                    @elseif($data->status == 3)
                    <a href="#" class="w-100 btn btn-danger text-white"><i class="fas fa-exclamation-circle"></i> REVISI (Silahkan cek feedback)</a>                    
                    @elseif($data->status == 0)
                        <a href="{{url($data->route)}}" class="w-100 btn btn-warning">MULAI</a>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
   
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