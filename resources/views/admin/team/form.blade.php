@extends('admin.layout')

@section('title', $member->exists ? 'Ubah Anggota Tim' : 'Tambah Anggota Tim')

@section('content')
<div class="page-head">
    <div><h1>{{ $member->exists ? 'Ubah Anggota Tim' : 'Tambah Anggota Tim' }}</h1></div>
    <a href="{{ route('admin.team.index') }}" class="btn btn-light"><x-icon name="arrow-left" size="16" stroke="2" />Kembali</a>
</div>

<form method="POST" enctype="multipart/form-data" action="{{ $member->exists ? route('admin.team.update', $member) : route('admin.team.store') }}" class="split">
    @csrf
    @if ($member->exists) @method('PUT') @endif

    <div class="main-col panel form">
        <div class="form-row">
            <x-admin.input name="name" label="Nama" :value="$member->name" required />
            <x-admin.input name="position" label="Jabatan / peran" :value="$member->position" required />
        </div>
        <x-admin.textarea name="bio" label="Profil singkat" :value="$member->bio" rows="4" />
        <x-admin.input name="linkedin" label="URL LinkedIn" type="url" :value="$member->linkedin" placeholder="https://linkedin.com/in/..." />
    </div>

    <div class="side-col">
        <div class="panel form">
            <x-admin.image name="photo" label="Foto" :url="$member->photoUrl()" hint="Persegi, maks. 1 MB." />
            <x-admin.input name="sort_order" label="Urutan tampil" type="number" min="0" :value="$member->sort_order ?? 0" />
            <x-admin.checkbox name="is_active" label="Tampilkan di website" :checked="$member->is_active" />
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.team.index') }}" class="btn btn-light">Batal</a>
        </div>
    </div>
</form>
@endsection
