@extends('admin.layout')

@section('title', $post->exists ? 'Ubah Artikel' : 'Tulis Artikel')

@section('content')
<div class="page-head">
    <div><h1>{{ $post->exists ? 'Ubah Artikel' : 'Tulis Artikel' }}</h1></div>
    <div class="actions">
        @if ($post->exists && $post->is_published)<a href="{{ route('blog.show', $post) }}" target="_blank" class="btn btn-light"><x-icon name="eye" size="16" stroke="2" />Lihat</a>@endif
        <a href="{{ route('admin.posts.index') }}" class="btn btn-light"><x-icon name="arrow-left" size="16" stroke="2" />Kembali</a>
    </div>
</div>

<form method="POST" enctype="multipart/form-data" action="{{ $post->exists ? route('admin.posts.update', $post) : route('admin.posts.store') }}" class="split">
    @csrf
    @if ($post->exists) @method('PUT') @endif

    <div class="main-col panel form">
        <x-admin.input name="title" label="Judul" :value="$post->title" required />
        <x-admin.textarea name="excerpt" label="Ringkasan" :value="$post->excerpt" rows="2" hint="Tampil di daftar artikel dan hasil pencarian Google. Maks. 300 karakter." />
        <x-admin.textarea name="body" label="Isi artikel" :value="$post->body" rows="22" code required />
        <details class="hint">
            <summary style="cursor: pointer; font-weight: 600">Panduan format Markdown</summary>
            <pre style="background: #F7F9FC; padding: 12px; border-radius: 10px; white-space: pre-wrap">## Subjudul
### Sub-subjudul
**teks tebal**  *teks miring*
- poin daftar
1. daftar bernomor
[teks tautan](https://alamat.com)
> kutipan
![keterangan gambar](https://alamat-gambar.jpg)</pre>
        </details>
    </div>

    <div class="side-col">
        <div class="panel form">
            <x-admin.checkbox name="is_published" label="Terbitkan" :checked="$post->is_published" />
            <x-admin.input name="published_at" label="Tanggal terbit" type="datetime-local" :value="$post->published_at?->format('Y-m-d\TH:i')" hint="Atur tanggal mendatang untuk menjadwalkan." />
            <x-admin.input name="category" label="Kategori" :value="$post->category" list="post-categories" placeholder="Tips, Berita, Panduan…" />
            <datalist id="post-categories">
                @foreach (\App\Models\Post::whereNotNull('category')->distinct()->pluck('category') as $cat)
                    <option value="{{ $cat }}">
                @endforeach
            </datalist>
            <x-admin.image name="cover_image" label="Gambar sampul" :url="$post->coverUrl()" hint="Rasio 2:1 disarankan. Maks. 3 MB." />
            <x-admin.input name="slug" label="Slug URL" :value="$post->slug" hint="Kosongkan untuk dibuat otomatis." />
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Simpan</button>
            @if ($post->exists)
                <x-admin.delete :action="route('admin.posts.destroy', $post)" label="Hapus" />
            @endif
        </div>
    </div>
</form>
@endsection
