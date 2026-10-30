@extends('admin.layout')

@section('title', 'Tim')

@section('content')
<div class="page-head">
    <div><h1>Tim</h1><p>Anggota tim yang tampil di halaman Tentang Kami.</p></div>
    <a href="{{ route('admin.team.create') }}" class="btn btn-primary"><x-icon name="plus" size="16" stroke="2.2" />Tambah Anggota</a>
</div>

<div class="table-wrap">
    <table>
        <thead><tr><th>Foto</th><th>Nama</th><th>Status</th><th style="width: 1%">Aksi</th></tr></thead>
        <tbody>
        @forelse ($members as $member)
            <tr>
                <td>@if ($member->photo)<img src="{{ $member->photoUrl() }}" alt="" class="thumb-sm" style="width: 44px; height: 44px; border-radius: 50%">@else<span class="sub">{{ $member->initials() }}</span>@endif</td>
                <td><strong>{{ $member->name }}</strong><span class="sub">{{ $member->position }}</span></td>
                <td><span class="badge {{ $member->is_active ? 'b-on' : 'b-off' }}">{{ $member->is_active ? 'Tampil' : 'Disembunyikan' }}</span></td>
                <td>
                    <div class="actions">
                        <a href="{{ route('admin.team.edit', $member) }}" class="btn btn-light btn-sm"><x-icon name="edit" size="15" stroke="2" />Ubah</a>
                        <x-admin.delete :action="route('admin.team.destroy', $member)" />
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="4" class="empty">Belum ada anggota tim.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
