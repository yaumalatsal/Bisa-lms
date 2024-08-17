@extends('template/index')
@section('content')
<section class="row" id="cover-page">
    <div class="col-lg-12 row">
        <div class="col-lg-6">
            <h1 class="font-weight nunito">Innovation<br>Village<span class="main-text"> Lab</span></h1>
            <p>
            Vilage Innovation Lab  adalah platform untuk memudahkan
            BUMDES menemukan objek usaha yang sesuai dengan
            potensi desa.
            </p>
        </div>
        <div class="col-lg-6 text-center">
            <img src="{{asset('assets/images/isometric.png')}}" class="w-60 m-3" alt="">
        </div>
    </div>
</section>
@endsection
