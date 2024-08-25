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
                        <div class="col-md-5">
                            <center><img src="{{asset('assets/images/ilustration/step/mentor.gif')}}" style="width:80%" alt=""></center>
                        </div>
                        <div class="col-md-6">
                            <br>
                            <h2>Selamat Datang, Mentor</h2>
                            <p>BisMA adalah platform monitoring dan inkubasi online yang membantu para Siswa untuk merumuskan
                                produk dan konsep bisnis nya. Disini peran mentor adalah untuk membimbing ide ide cemerlang dari Siswa sesuai dengan syarat
                                standar produk yang layak jual dan layak di publish. Mohon dukungannya :)
                                <br>
                                <!-- <a href="{{url('/submitDeck')}}" class="btn btn-primary">Submit Progress <i class="fas fa-arrow-alt-circle-right"></i></a> -->
                            </p>                         
                            <p>
                                @foreach($data as $mentor)
                                <table class="table">
                                    <tr>
                                        <td>Nama Lengkap </td>
                                        <td> : </td>
                                        <td>{{$mentor->nama}}</td>
                                    </tr>
                                    <tr>
                                        <td>No Telfon </td>
                                        <td> : </td>
                                        <td>{{$mentor->nomor_telepon}}</td>
                                    </tr>
                                    <tr>
                                        <td>Email </td>
                                        <td> : </td>
                                        <td>{{$mentor->email}}</td>
                                    </tr>
                                    <tr>
                                        <td>Instansi </td>
                                        <td> : </td>
                                        <td>{{$mentor->instansi}}</td>
                                    </tr>
                                </table>
                                @endforeach
                            </p>
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