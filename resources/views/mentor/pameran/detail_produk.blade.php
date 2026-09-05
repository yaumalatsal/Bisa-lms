@extends('mentor.template.index')

@section('title-page', 'Detail Produk Pameran')

@section('content')
    @include('partials.product-detail', [
        'bmcRoute' => 'mentor.pameran.result_bmc',
        'canEditTrack' => false,
    ])
@endsection
