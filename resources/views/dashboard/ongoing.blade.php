@section('title-page')
    Dashboard
@endsection
@extends('dashboard_template/index')
@section('content')
<div class="container-fluid">
    <div class="row text-center mt-5">
        <center><img src="{{asset('assets/images/alur3.png')}}" style="width:200px" alt=""></center>
        <br><br>    
        <h2>Pengajuan Produk Anda Masih Dalam <br>  Proses Validasi dari Mentor</h2>
        <p>Jika dalam 2 x 24 jam, produk masih belum mendapat validasi. Silahkan hubungi guru pengampuh (mentor) yang anda pilih pada pendaftaran produk </p>
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