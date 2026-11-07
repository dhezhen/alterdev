@php
    $featuresText = $package['features_text'] ?? implode(PHP_EOL, $package['features'] ?? []);
    $servicesText = $package['services_text'] ?? implode(PHP_EOL, $package['services'] ?? []);
@endphp
<fieldset class="package-row" data-package-row>
    <div class="package-row-head">
        <legend>Paket layanan</legend>
        <button type="button" class="btn btn-light btn-sm" data-remove-package>Hapus paket</button>
    </div>
    <div class="form-row">
        <div class="field">
            <label for="package-{{ $index }}-name">Nama paket</label>
            <input class="input" id="package-{{ $index }}-name" name="packages[{{ $index }}][name]" value="{{ old('packages.'.$index.'.name', $package['name'] ?? '') }}" placeholder="Paket Standar">
        </div>
        <div class="field">
            <label for="package-{{ $index }}-price">Harga jual (Rp)</label>
            <input class="input" id="package-{{ $index }}-price" type="number" min="0" step="50000" name="packages[{{ $index }}][price]" value="{{ old('packages.'.$index.'.price', $package['price'] ?? '') }}" placeholder="1500000">
            @error('packages.'.$index.'.price')<span class="error">{{ $message }}</span>@enderror
        </div>
        <div class="field">
            <label for="package-{{ $index }}-core-price">Harga core internal (Rp)</label>
            <input class="input" id="package-{{ $index }}-core-price" type="number" min="0" step="50000" name="packages[{{ $index }}][core_price]" value="{{ old('packages.'.$index.'.core_price', $package['core_price'] ?? '') }}" placeholder="Biaya internal">
            @error('packages.'.$index.'.core_price')<span class="error">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="form-row">
        <div class="field">
            <label for="package-{{ $index }}-price-display">Format harga di website</label>
            <input class="input" id="package-{{ $index }}-price-display" name="packages[{{ $index }}][price_display]" value="{{ old('packages.'.$index.'.price_display', $package['price_display'] ?? '') }}" placeholder="Rp 1 juta">
        </div>
        <div class="field">
            <label for="package-{{ $index }}-compare-price">Harga sebelum diskon (Rp)</label>
            <input class="input" id="package-{{ $index }}-compare-price" type="number" min="0" step="50000" name="packages[{{ $index }}][compare_price]" value="{{ old('packages.'.$index.'.compare_price', $package['compare_price'] ?? '') }}" placeholder="1500000">
        </div>
        <div class="field">
            <label for="package-{{ $index }}-compare-price-display">Format harga sebelum diskon</label>
            <input class="input" id="package-{{ $index }}-compare-price-display" name="packages[{{ $index }}][compare_price_display]" value="{{ old('packages.'.$index.'.compare_price_display', $package['compare_price_display'] ?? '') }}" placeholder="Rp 1.500.000,-">
        </div>
    </div>
    <div class="form-row">
        <div class="field">
            <label for="package-{{ $index }}-price-kicker">Teks di atas harga</label>
            <input class="input" id="package-{{ $index }}-price-kicker" name="packages[{{ $index }}][price_kicker]" value="{{ old('packages.'.$index.'.price_kicker', $package['price_kicker'] ?? '') }}" placeholder="Start From:">
        </div>
        <div class="field">
            <label for="package-{{ $index }}-discount-label">Label diskon</label>
            <input class="input" id="package-{{ $index }}-discount-label" name="packages[{{ $index }}][discount_label]" value="{{ old('packages.'.$index.'.discount_label', $package['discount_label'] ?? '') }}" placeholder="33% OFF">
        </div>
        <div class="field">
            <label for="package-{{ $index }}-price-note">Catatan harga</label>
            <input class="input" id="package-{{ $index }}-price-note" name="packages[{{ $index }}][price_note]" value="{{ old('packages.'.$index.'.price_note', $package['price_note'] ?? '') }}" placeholder="(FREE domain & hosting)">
        </div>
    </div>
    <div class="field">
        <label for="package-{{ $index }}-summary">Ringkasan paket</label>
        <input class="input" id="package-{{ $index }}-summary" name="packages[{{ $index }}][summary]" value="{{ old('packages.'.$index.'.summary', $package['summary'] ?? '') }}" placeholder="Cocok untuk kebutuhan website profil dasar">
    </div>
    <div class="form-row">
        <div class="field">
            <label for="package-{{ $index }}-features">Fitur yang termasuk</label>
            <textarea class="input" id="package-{{ $index }}-features" rows="4" name="packages[{{ $index }}][features_text]" placeholder="Satu fitur per baris">{{ old('packages.'.$index.'.features_text', $featuresText) }}</textarea>
        </div>
        <div class="field">
            <label for="package-{{ $index }}-excluded-features">Fitur yang tidak termasuk</label>
            <textarea class="input" id="package-{{ $index }}-excluded-features" rows="4" name="packages[{{ $index }}][excluded_features_text]" placeholder="Satu fitur per baris">{{ old('packages.'.$index.'.excluded_features_text', implode(PHP_EOL, $package['excluded_features'] ?? [])) }}</textarea>
        </div>
        <div class="field">
            <label for="package-{{ $index }}-services">Layanan yang termasuk</label>
            <textarea class="input" id="package-{{ $index }}-services" rows="4" name="packages[{{ $index }}][services_text]" placeholder="Satu layanan per baris">{{ old('packages.'.$index.'.services_text', $servicesText) }}</textarea>
        </div>
    </div>
    <div class="form-row">
        <div class="field">
            <label for="package-{{ $index }}-renewal-label">Biaya perpanjangan</label>
            <input class="input" id="package-{{ $index }}-renewal-label" name="packages[{{ $index }}][renewal_label]" value="{{ old('packages.'.$index.'.renewal_label', $package['renewal_label'] ?? '') }}" placeholder="Perpanjang 500rb/tahun">
        </div>
        <div class="field">
            <label for="package-{{ $index }}-accent-color">Warna paket</label>
            <select class="input" id="package-{{ $index }}-accent-color" name="packages[{{ $index }}][accent_color]">
                @foreach (['blue' => 'Biru', 'teal' => 'Hijau toska', 'coral' => 'Merah koral'] as $color => $label)
                    <option value="{{ $color }}" @selected(old('packages.'.$index.'.accent_color', $package['accent_color'] ?? 'blue') === $color)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <label class="check"><input type="checkbox" name="packages[{{ $index }}][is_published]" value="1" @checked(old('packages.'.$index.'.is_published', $package['is_published'] ?? false))> Tampilkan paket ini di website</label>
</fieldset>
