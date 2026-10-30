@extends('admin.layout')

@section('title', $user->exists ? 'Ubah Admin' : 'Tambah Admin')

@section('content')
<div class="page-head">
    <div><h1>{{ $user->exists ? 'Ubah Admin' : 'Tambah Admin' }}</h1></div>
    <a href="{{ route('admin.users.index') }}" class="btn btn-light"><x-icon name="arrow-left" size="16" stroke="2" />Kembali</a>
</div>

<form method="POST" action="{{ $user->exists ? route('admin.users.update', $user) : route('admin.users.store') }}" class="panel form" style="max-width: 720px">
    @csrf
    @if ($user->exists) @method('PUT') @endif
    <x-admin.input name="name" label="Nama" :value="$user->name" required />
    <x-admin.input name="email" label="Email" type="email" :value="$user->email" required />
    <div class="form-row">
        <x-admin.input name="password" label="Password" type="password" :required="! $user->exists" autocomplete="new-password" :hint="$user->exists ? 'Kosongkan bila tidak diubah.' : 'Minimal 10 karakter, berisi huruf dan angka.'" />
        <x-admin.input name="password_confirmation" label="Ulangi password" type="password" autocomplete="new-password" />
    </div>
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-light">Batal</a>
    </div>
</form>
@endsection
