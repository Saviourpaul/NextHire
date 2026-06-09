@props([
    'name',
    'label',
    'type' => 'text',
    'value' => null,
    'autocomplete' => null,
    'autofocus' => false,
    'required' => false,
])

<div class="auth-field">
    <label class="auth-label" for="{{ $name }}">
        {{ $label }} @if ($required)<span class="auth-required">*</span>@endif
    </label>

    <input
        id="{{ $name }}"
        type="{{ $type }}"
        name="{{ $name }}"
        class="form-control auth-control @error($name) is-invalid @enderror"
        @if ($type !== 'password') value="{{ old($name, $value) }}" @endif
        @if ($required) required @endif
        @if ($autofocus) autofocus @endif
        @if ($autocomplete) autocomplete="{{ $autocomplete }}" @endif
        {{ $attributes }}
    >

    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>
