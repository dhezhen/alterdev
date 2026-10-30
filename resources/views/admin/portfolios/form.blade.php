@extends('admin.layout')

@section('title', $portfolio->exists ? 'Ubah Proyek' : 'Tambah Proyek')

@section('content')
<div class="page-head">
    <div><h1>{{ $portfolio->exists ? 'Ubah Proyek' : 'Tambah Proyek' }}</h1></div>
    <div class="actions">
        @if ($portfolio->exists && $portfolio->is_active)<a href="{{ route('portfolios.show', $portfolio) }}" target="_blank" class="btn btn-light"><x-icon name="eye" size="16" stroke="2" />Lihat</a>@endif
        <a href="{{ route('admin.portfolios.index') }}" class="btn btn-light"><x-icon name="arrow-left" size="16" stroke="2" />Kembali</a>
    </div>
</div>

<form method="POST" enctype="multipart/form-data" action="{{ $portfolio->exists ? route('admin.portfolios.update', $portfolio) : route('admin.portfolios.store') }}" class="split">
    @csrf
    @if ($portfolio->exists) @method('PUT') @endif

    <div class="main-col panel form">
        <x-admin.input name="title" label="Judul proyek" :value="$portfolio->title" required />
        <x-admin.textarea name="summary" label="Ringkasan" :value="$portfolio->summary" rows="3" required hint="Tampil di kartu portofolio. Maksimal 300 karakter." />
        <x-admin.textarea name="challenge" label="Tantangan" :value="$portfolio->challenge" rows="4" hint="Masalah yang dihadapi klien. Mendukung Markdown." />
        <x-admin.textarea name="solution" label="Solusi" :value="$portfolio->solution" rows="4" hint="Apa yang kami bangun. Mendukung Markdown." />
        <x-admin.textarea name="result" label="Hasil" :value="$portfolio->result" rows="4" hint="Dampak setelah sistem digunakan. Mendukung Markdown." />
    </div>

    <div class="side-col">
        <div class="panel form">
            <x-admin.select name="category" label="Kategori" :options="\App\Models\Portfolio::CATEGORIES" :value="$portfolio->category" required />
            <x-admin.image name="image" label="Gambar / tangkapan layar" :url="$portfolio->imageUrl()" hint="Rasio 16:9 disarankan. Maks. 2 MB." />
            <div class="form-row">
                <x-admin.input name="client" label="Klien" :value="$portfolio->client" />
                <x-admin.input name="year" label="Tahun" :value="$portfolio->year" />
            </div>
            <x-admin.input name="tags_text" label="Tag" :value="implode(', ', $portfolio->tags ?? [])" hint="Pisahkan dengan koma." />
            <x-admin.input name="url" label="Tautan proyek" type="url" :value="$portfolio->url" placeholder="https://" />
            <x-admin.input name="slug" label="Slug URL" :value="$portfolio->slug" hint="Kosongkan untuk dibuat otomatis." />
            <x-admin.input name="sort_order" label="Urutan tampil" type="number" min="0" :value="$portfolio->sort_order ?? 0" />
            <x-admin.checkbox name="is_featured" label="Jadikan unggulan (tampil lebih dulu)" :checked="$portfolio->is_featured" />
            <x-admin.checkbox name="is_active" label="Tampilkan di website" :checked="$portfolio->is_active" />
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.portfolios.index') }}" class="btn btn-light">Batal</a>
        </div>
    </div>
</form>
@endsection
