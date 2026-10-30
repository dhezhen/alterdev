@props(['name', 'label', 'value' => null, 'type' => 'text', 'hint' => null, 'required' => false])
@php $id = 'f-'.str_replace(['[', ']'], '-', $name); @endphp
<div class="field">
    <label for="{{ $id }}">{{ $label }}@if ($required) <span style="color: var(--danger)">*</span>@endif</label>
    <input id="{{ $id }}" name="{{ $name }}" type="{{ $type }}" value="{{ $type === 'password' ? '' : old($name, $value) }}"
        @class(['input', 'is-invalid' => $errors->has($name)]) @if ($required) required @endif {{ $attributes }}>
    @if ($hint)<span class="hint">{{ $hint }}</span>@endif
    @error($name)<span class="error">{{ $message }}</span>@enderror
</div>
