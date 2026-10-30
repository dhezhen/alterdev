@extends('admin.layout')

@section('title', $testimonial->exists ? 'Ubah Testimoni' : 'Tambah Testimoni')

@section('content')
<div class="page-head">
    <div><h1>{{ $testimonial->exists ? 'Ubah Testimoni' : 'Tambah Testimoni' }}</h1></div>
    <a href="{{ route('admin.testimonials.index') }}" class="btn btn-light"><x-icon name="arrow-left" size="16" stroke="2" />Kembali</a>
</div>

<form method="POST" enctype="multipart/form-data" action="{{ $testimonial->exists ? route('admin.testimonials.update', $testimonial) : route('admin.testimonials.store') }}" class="split">
    @csrf
    @if ($testimonial->exists) @method('PUT') @endif

    <div class="main-col panel form">
        <div class="form-row">
            <x-admin.input name="name" label="Nama klien" :value="$testimonial->name" required />
            <x-admin.input name="position" label="Jabatan" :value="$testimonial->position" />
        </div>
        <x-admin.input name="organization" label="Instansi / usaha" :value="$testimonial->organization" />
        <x-admin.textarea name="content" label="Isi testimoni" :value="$testimonial->content" rows="6" required />
    </div>

    <div class="side-col">
        <div class="panel form">
            <x-admin.select name="rating" label="Rating" :options="[5 => '★★★★★ (5)', 4 => '★★★★ (4)', 3 => '★★★ (3)', 2 => '★★ (2)', 1 => '★ (1)']" :value="$testimonial->rating" />
            <x-admin.image name="photo" label="Foto (opsional)" :url="$testimonial->photoUrl()" hint="Persegi, maks. 1 MB. Tanpa foto akan tampil inisial nama." />
            <x-admin.input name="sort_order" label="Urutan tampil" type="number" min="0" :value="$testimonial->sort_order ?? 0" />
            <x-admin.checkbox name="is_active" label="Tampilkan di website" :checked="$testimonial->is_active" />
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.testimonials.index') }}" class="btn btn-light">Batal</a>
        </div>
    </div>
</form>
@endsection
