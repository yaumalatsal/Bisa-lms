{{--
    One place that renders feedback. Controllers flash `status`, `success` and
    `error` fairly interchangeably and each view used to re-implement its own
    alert markup (or drop the message on the floor). All three keys land here.
--}}
@php
    $flashes = collect([
        'success' => ['success', 'mdi-check-circle'],
        'status' => ['info', 'mdi-information'],
        'error' => ['danger', 'mdi-alert-circle'],
        'login_error' => ['danger', 'mdi-alert-circle'],
        'warning' => ['warning', 'mdi-alert'],
    ])->filter(fn ($meta, $key) => session()->has($key));
@endphp

@foreach ($flashes as $key => [$variant, $icon])
    <div class="alert alert-{{ $variant }} alert-dismissible fade show" role="alert">
        <i class="mdi {{ $icon }} flex-shrink-0" aria-hidden="true"></i>
        <div class="flex-grow-1">{{ session($key) }}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
@endforeach

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="mdi mdi-alert-circle flex-shrink-0" aria-hidden="true"></i>
        <div class="flex-grow-1">
            <strong>Periksa kembali isian Anda.</strong>
            <ul class="mb-0 mt-2 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
@endif
