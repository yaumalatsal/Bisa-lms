@props([
    'name',
    'label',
    'type' => 'text',
    'autocomplete' => null,
    'required' => true,
    'value' => null,
])

<div class="form-group">
    <label class="form-label" for="{{ $name }}">{{ $label }}</label>
    <input
        id="{{ $name }}"
        name="{{ $name }}"
        type="{{ $type }}"
        value="{{ old($name, $value) }}"
        @if ($autocomplete) autocomplete="{{ $autocomplete }}" @endif
        @required($required)
        @class(['form-control', 'is-invalid' => $errors->has($name)])
        @if ($errors->has($name)) aria-invalid="true" aria-describedby="{{ $name }}-error" @endif>

    @error($name)
        <div class="invalid-feedback d-block" id="{{ $name }}-error">{{ $message }}</div>
    @enderror
</div>
