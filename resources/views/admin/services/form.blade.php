@extends('admin.layout')

@section('title', $service->exists ? 'Ubah Layanan' : 'Tambah Layanan')

@section('content')
@php($packages = array_values(old('packages', $service->pricing_packages ?? [])))
<div class="page-head">
    <div><h1>{{ $service->exists ? 'Ubah Layanan' : 'Tambah Layanan' }}</h1></div>
    <a href="{{ route('admin.services.index') }}" class="btn btn-light"><x-icon name="arrow-left" size="16" stroke="2" />Kembali</a>
</div>

<form method="POST" action="{{ $service->exists ? route('admin.services.update', $service) : route('admin.services.store') }}" class="split">
    @csrf
    @if ($service->exists) @method('PUT') @endif

    <div class="main-col service-main">
        <div class="panel form">
            <x-admin.input name="title" label="Judul layanan" :value="$service->title" required />
            <x-admin.textarea name="short_description" label="Deskripsi singkat" :value="$service->short_description" rows="3" required hint="Tampil di kartu layanan. Maksimal 255 karakter." />
            <x-admin.textarea name="features_text" label="Poin manfaat" :value="implode(PHP_EOL, $service->features ?? [])" rows="4" hint="Satu baris satu poin." />
            <x-admin.textarea name="description" label="Deskripsi lengkap (halaman detail)" :value="$service->description" rows="14" code hint="Mendukung Markdown: ## Judul, - poin, **tebal**, [tautan](https://...)." />
        </div>

        <section class="panel form package-editor" data-package-editor data-next-index="{{ count($packages) }}">
            <div class="package-editor-head">
                <div>
                    <h2>Paket harga</h2>
                    <p class="hint">Harga core hanya untuk admin. Paket baru tidak tampil di website sampai dicentang.</p>
                </div>
                <button type="button" class="btn btn-light btn-sm" data-add-package>Tambah Paket</button>
            </div>
            <div class="package-list" data-package-list>
                @foreach ($packages as $index => $package)
                    @include('admin.services._pricing-package-row', ['index' => $index, 'package' => $package])
                @endforeach
            </div>
            <template data-package-template>
                @include('admin.services._pricing-package-row', ['index' => '__INDEX__', 'package' => []])
            </template>
        </section>
    </div>

    <div class="side-col">
        <div class="panel form">
            <x-admin.select name="icon" label="Ikon" :options="\App\Support\Icons::OPTIONS" :value="$service->icon" />
            <x-admin.input name="price_label" label="Catatan harga singkat" :value="$service->price_label" hint="Opsional; tampil sebagai catatan di halaman layanan." />
            <x-admin.select name="portfolio_category" label="Kategori portofolio terkait" :options="\App\Models\Portfolio::CATEGORIES" :value="$service->portfolio_category" placeholder="— Tidak ada —" hint="Proyek dari kategori ini tampil di halaman detail layanan." />
            <x-admin.input name="slug" label="Slug URL" :value="$service->slug" hint="Kosongkan untuk dibuat otomatis dari judul." />
            <x-admin.input name="sort_order" label="Urutan tampil" type="number" min="0" :value="$service->sort_order ?? 0" />
            <x-admin.checkbox name="is_active" label="Tampilkan di website" :checked="$service->is_active" />
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.services.index') }}" class="btn btn-light">Batal</a>
        </div>
    </div>
</form>
@endsection
