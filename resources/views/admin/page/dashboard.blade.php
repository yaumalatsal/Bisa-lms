@section('title-page')
    Dashboard
@endsection

@section('css')
<style>
    .card-step {
        min-height: 350px;
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .card-step:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    .card-step .card-body {
        padding: 20px;
    }
    .card-step img {
        width: 100%; /* Maintain full width */
        height: 200px; /* Set a fixed height */
        object-fit: cover; /* Ensure the image covers the area without distortion */
        border-bottom: 1px solid #ddd; /* Optional: add a border under the image */
    }
    .card-step .deskripsi-step {
        height: 90px;
        overflow: hidden;
    }
    .card-step .btn {
        margin-top: 10px;
    }
    .card-step .read-more {
        display: block;
        margin-top: 10px;
        text-align: center;
        color: #007bff;
        text-decoration: none;
    }
</style>
@endsection

@extends('admin/template/index')

@section('content')
<div class="container-fluid">

    <div class="row p-30">
        <!-- Card 1: BMC -->
        <div class="col-md-4 col-sm-6 mb-4">
            <div class="card card-step">
                <div class="card-body">
                    <img src="{{asset('assets/images/ilustration/step/bmc.gif')}}" alt="BMC">
                    <h5 class="mt-3">BMC (Business Model Canvas)</h5>
                    <p class="deskripsi-step">Deskripsi singkat mengenai BMC dan bagaimana cara menggunakannya untuk merencanakan bisnis Anda dengan lebih baik.</p>
                    <a href="{{url('artikel/bmc')}}" class="w-100 btn btn-primary">Pelajari Lebih Lanjut</a>
                </div>
            </div>
        </div>
        
        <!-- Card 2: Cara Memulai Bisnis -->
        <div class="col-md-4 col-sm-6 mb-4">
            <div class="card card-step">
                <div class="card-body">
                    <img src="{{asset('assets/images/ilustration/step/presen.gif')}}" alt="Cara Memulai Bisnis">
                    <h5 class="mt-3">Cara Memulai Bisnis</h5>
                    <p class="deskripsi-step">Panduan langkah demi langkah tentang cara memulai bisnis dari nol hingga sukses.</p>
                    <a href="{{url('cara-memulai-bisnis')}}" class="w-100 btn btn-primary">Pelajari Lebih Lanjut</a>
                </div>
            </div>
        </div>

        <!-- Card 3: Ide Bisnis -->
        <div class="col-md-4 col-sm-6 mb-4">
            <div class="card card-step">
                <div class="card-body">
                    <img src="{{asset('assets/images/ilustration/step/publis.gif')}}" alt="Ide Bisnis">
                    <h5 class="mt-3">Ide Bisnis</h5>
                    <p class="deskripsi-step">Temukan ide-ide bisnis kreatif dan inovatif untuk memulai usaha yang sukses.</p>
                    <a href="{{url('ide-bisnis')}}" class="w-100 btn btn-primary">Pelajari Lebih Lanjut</a>
                </div>
            </div>
        </div>
    </div>
    <h4>Hasil Penilaian Produk</h2>
    <br>
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
               
                    
            </tbody>
        </table> 
    </div>
</div>


@endsection



