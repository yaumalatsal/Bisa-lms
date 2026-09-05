{{-- Cross-links between the four sign-in areas. --}}
@props(['links' => []])

<div class="auth__switch">
    <span class="auth__switch-label">Masuk sebagai peran lain</span>
    @foreach ($links as $label => $href)
        <a href="{{ $href }}" class="btn btn-sm btn-secondary">{{ $label }}</a>
    @endforeach
</div>
