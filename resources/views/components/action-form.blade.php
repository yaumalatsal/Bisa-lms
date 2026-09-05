{{--
    Submits a state-changing action as a real form (CSRF-protected) instead of a
    bare <a href>, which browsers and crawlers are free to prefetch.

    <x-action-form :action="url('/submit_bmc')" class="btn btn-danger">Submit</x-action-form>
--}}
@props([
    'action',
    'method' => 'POST',
    'confirm' => null,
    'class' => 'btn btn-primary',
])

<form action="{{ $action }}" method="POST" class="d-inline"
    @if ($confirm) onsubmit="return confirm(@js($confirm))" @endif>
    @csrf
    @unless (strtoupper($method) === 'POST')
        @method($method)
    @endunless
    <button type="submit" class="{{ $class }}">{{ $slot }}</button>
</form>
