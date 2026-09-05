@section('title-page')
    Dashboard
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
                    <a href="{{ route('dashboard.materi.bmc') }}" class="w-100 btn btn-primary">Pelajari Lebih Lanjut</a>
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



