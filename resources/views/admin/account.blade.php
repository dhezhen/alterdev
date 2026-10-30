@extends('admin.layout')

@section('title', 'Akun Saya')

@section('content')
<div class="page-head">
    <div><h1>Akun Saya</h1><p>Ubah nama, email, atau password login Anda.</p></div>
</div>

<form method="POST" action="{{ route('admin.account.update') }}" style="max-width: 720px">
    @csrf
    @method('PUT')
    <section class="panel form">
        <h2 style="margin: 0">Profil</h2>
        <x-admin.input name="name" label="Nama" :value="$user->name" required />
        <x-admin.input name="email" label="Email" type="email" :value="$user->email" required />
    </section>
    <section class="panel form">
        <h2 style="margin: 0">Ganti password</h2>
        <p class="hint">Kosongkan bila tidak ingin mengganti password.</p>
        <x-admin.input name="current_password" label="Password saat ini" type="password" autocomplete="current-password" />
        <div class="form-row">
            <x-admin.input name="password" label="Password baru" type="password" autocomplete="new-password" hint="Minimal 10 karakter, berisi huruf dan angka." />
            <x-admin.input name="password_confirmation" label="Ulangi password baru" type="password" autocomplete="new-password" />
        </div>
    </section>
    <div class="form-actions" style="margin-top: 20px">
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>
@endsection
