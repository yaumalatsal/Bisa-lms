@extends('admin.template.index')

@section('title-page', 'Detail Produk')

@section('content')
    @include('partials.product-detail', [
        'bmcRoute' => 'admin.produk.result_bmc',
        'canEditTrack' => false,
    ])
@endsection
