@extends('admin.layout')

@section('title', 'Pengguna Admin')

@section('content')
<div class="page-head">
    <div><h1>Pengguna Admin</h1><p>Orang yang dapat masuk ke panel admin.</p></div>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary"><x-icon name="plus" size="16" stroke="2.2" />Tambah Admin</a>
</div>

<div class="table-wrap">
    <table>
        <thead><tr><th>Nama</th><th>Email</th><th>Dibuat</th><th style="width: 1%">Aksi</th></tr></thead>
        <tbody>
        @foreach ($users as $user)
            <tr>
                <td><strong>{{ $user->name }}</strong>@if ($user->is(auth()->user())) <span class="badge b-confirmed">Anda</span>@endif</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at?->format('d/m/Y') }}</td>
                <td>
                    <div class="actions">
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-light btn-sm"><x-icon name="edit" size="15" stroke="2" />Ubah</a>
                        @unless ($user->is(auth()->user()))
                            <x-admin.delete :action="route('admin.users.destroy', $user)" confirm="Hapus akses admin untuk {{ $user->name }}?" />
                        @endunless
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
