{{-- Formulir kontak / konsultasi --}}
<form method="POST" action="{{ route('contact.store') }}#kontak" class="form" novalidate>
    @csrf
    @if (session('success'))
        <div class="alert alert-success" role="status">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-error" role="alert">Mohon periksa kembali isian Anda.</div>
    @endif

    <div class="hp" aria-hidden="true">
        <label>Jangan diisi <input type="text" name="website" tabindex="-1" autocomplete="off"></label>
    </div>

    <div class="form-grid">
        <label class="field">Nama
            <input class="input" type="text" name="name" value="{{ old('name') }}" placeholder="Nama lengkap Anda" required>
            @error('name')<span class="error">{{ $message }}</span>@enderror
        </label>
        <label class="field">No. WhatsApp / Email
            <input class="input" type="text" name="contact" value="{{ old('contact') }}" placeholder="Agar kami bisa menghubungi Anda" required>
            @error('contact')<span class="error">{{ $message }}</span>@enderror
        </label>
    </div>
    <div class="form-grid">
        <label class="field">Instansi / Usaha
            <input class="input" type="text" name="institution" value="{{ old('institution') }}" placeholder="Opsional">
        </label>
        <label class="field">Layanan yang dibutuhkan
            <select class="input" name="service">
                @foreach (\App\Models\Message::SERVICES as $option)
                    <option value="{{ $option }}" @selected(old('service', request('layanan')) === $option)>{{ $option }}</option>
                @endforeach
            </select>
            @error('service')<span class="error">{{ $message }}</span>@enderror
        </label>
    </div>
    <label class="field">Ceritakan kebutuhan Anda
        <textarea class="input" name="message" rows="4" placeholder="Misalnya: kami ingin pendaftaran santri baru bisa dilakukan secara online…" required>{{ old('message') }}</textarea>
        @error('message')<span class="error">{{ $message }}</span>@enderror
    </label>
    <button type="submit" class="btn btn-primary" style="align-self: flex-start">Kirim Pesan</button>
</form>
