@extends('investor.template.index')

@section('title-page', 'Detail Produk')

@section('content')
    @include('partials.product-detail', [
        'bmcRoute' => 'investor.produk.result_bmc',
        'canEditTrack' => false,
    ])
@endsection
