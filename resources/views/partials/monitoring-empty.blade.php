{{-- Ditampilkan bila produk belum punya laporan bulanan yang disetujui. --}}
<div class="card">
    <div class="bisa-empty">
        <i class="mdi mdi-chart-line bisa-empty__icon" aria-hidden="true"></i>
        <p class="bisa-empty__title">Belum ada data monitoring</p>
        <p class="bisa-empty__body">{{ $message }}</p>
        @isset($action)
            {{ $action }}
        @endisset
    </div>
</div>
