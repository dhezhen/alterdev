@props(['name', 'label', 'value' => null, 'rows' => 4, 'hint' => null, 'required' => false, 'code' => false])
@php $id = 'f-'.$name; @endphp
<div class="field">
    <label for="{{ $id }}">{{ $label }}@if ($required) <span style="color: var(--danger)">*</span>@endif</label>
    <textarea id="{{ $id }}" name="{{ $name }}" rows="{{ $rows }}" @class(['input', 'code' => $code, 'is-invalid' => $errors->has($name)]) @if ($required) required @endif {{ $attributes }}>{{ old($name, $value) }}</textarea>
    @if ($hint)<span class="hint">{{ $hint }}</span>@endif
    @error($name)<span class="error">{{ $message }}</span>@enderror
</div>
