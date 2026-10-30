@props(['name', 'label', 'options' => [], 'value' => null, 'hint' => null, 'placeholder' => null, 'required' => false])
@php
    $id = 'f-'.$name;
    $current = (string) old($name, $value);
    // Terima array asosiatif (value => label) maupun daftar biasa
    $isList = array_is_list($options);
@endphp
<div class="field">
    <label for="{{ $id }}">{{ $label }}@if ($required) <span style="color: var(--danger)">*</span>@endif</label>
    <select id="{{ $id }}" name="{{ $name }}" @class(['input', 'is-invalid' => $errors->has($name)]) @if ($required) required @endif {{ $attributes }}>
        @if ($placeholder !== null)<option value="">{{ $placeholder }}</option>@endif
        @foreach ($options as $key => $text)
            @php $optValue = $isList ? $text : $key; @endphp
            <option value="{{ $optValue }}" @selected($current === (string) $optValue)>{{ $text }}</option>
        @endforeach
    </select>
    @if ($hint)<span class="hint">{{ $hint }}</span>@endif
    @error($name)<span class="error">{{ $message }}</span>@enderror
</div>
