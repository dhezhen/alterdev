@props(['name', 'label', 'url' => null, 'hint' => 'Format JPG, PNG, atau WEBP.'])
<div class="field">
    <label for="f-{{ $name }}">{{ $label }}</label>
    @if ($url)
        <div style="display: flex; gap: 14px; align-items: center; flex-wrap: wrap">
            <img src="{{ $url }}" alt="" class="thumb">
            <label class="check" style="font-weight: 500"><input type="checkbox" name="remove_{{ $name }}" value="1"> Hapus gambar</label>
        </div>
    @endif
    <input id="f-{{ $name }}" type="file" name="{{ $name }}" accept="image/jpeg,image/png,image/webp" @class(['input', 'is-invalid' => $errors->has($name)])>
    <span class="hint">{{ $hint }}</span>
    @error($name)<span class="error">{{ $message }}</span>@enderror
</div>
