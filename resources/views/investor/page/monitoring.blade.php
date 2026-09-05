@extends('investor.template.index')

@section('title-page', 'Monitoring Bisnis')
@section('page-subtitle', 'Ringkasan penjualan, pemasukan dan profit tim ini.')

@section('content')
    @if (empty($monthlyReports))
        @include('partials.monitoring-empty', ['message' => $message ?? 'Belum ada laporan bulanan yang disetujui.'])
    @else
        @include('partials.monitoring-dashboard')
    @endif
@endsection
