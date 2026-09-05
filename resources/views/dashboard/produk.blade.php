@extends('dashboard_template.index')

@section('title-page', 'Produk Tim Saya')

@section('content')
    @include('partials.product-detail', [
        'bmcRoute' => 'dashboard.produk.result_bmc',
        'canEditTrack' => false,
    ])
@endsection
