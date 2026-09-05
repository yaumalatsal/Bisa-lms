@extends('mentor.template.index')

@section('title-page', 'Detail Produk Bimbingan')

@section('content')
    @include('partials.product-detail', [
        'bmcRoute' => 'mentor.result_bmc',
        'canEditTrack' => true,
    ])
@endsection
