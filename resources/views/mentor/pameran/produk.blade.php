@extends('mentor/template/index')



@section('css')
<style>
    /* Tema Profesional dan Elegan */


    h3, p {
        color: #444;
    }

    .card-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: space-between;
    }

    .card-product {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        width: 100%;
        max-width: 300px;
        margin-bottom: 20px;
        text-align: center;
        color: #333;
        transform: translateY(-100px);
        opacity: 0;
        animation: fall 0.8s ease-out forwards;
    }

    .card-product:nth-child(odd) {
        animation-delay: 0.2s;
    }

    .card-product:nth-child(even) {
        animation-delay: 0.4s;
    }

    @keyframes fall {
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .card-product img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-bottom: 1px solid #ddd;
    }

    .card-product .card-body {
        padding: 15px;
    }

    .card-product .card-title {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 10px;
        color: #333;
    }

    .card-product .card-text {
        color: #777;
        font-size: 14px;
        margin-bottom: 15px;
    }

    .card-product .btn {
        background-color: #007bff;
        color: #fff;
        padding: 10px 15px;
        border-radius: 20px;
        text-decoration: none;
        font-weight: bold;
    }

    .card-product .btn:hover {
        background-color: #0056b3;
    }

    .default-logo {
        width: 100%;
        height: 200px;
        background-color: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: #6c757d;
        border-bottom: 1px solid #ddd;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <h3>Daftar Produk Inkubasi :</h3>
    <p>Pilih nama produk :</p>
    <div class="card-container">
        @foreach($products as $data)
        <div class="card-product">
            @if($data->logoProduk == NULL || !file_exists(public_path('logo_produk/' . $data->logoProduk->logo_produk)))
            <div class="default-logo">No Logo Available</div>
            @else
            <img src="{{ asset('logo_produk/'.$data->logoProduk->logo_produk) }}" alt="{{ $data->nama_produk }}">
            @endif
            <div class="card-body">
                <h4 class="card-title">{{ $data->nama_produk }}</h4>
                <p class="card-text">CEO: {{ $data->ceo->nama }}</p>
                <a href="{{ route('mentor.pameran.detail', $data->id) }}" class="btn">
                    Detail Produk &nbsp;<i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@section('js')
<script>
    $(function(){
        $("#table-one").DataTable();
    });
</script>
@endsection
