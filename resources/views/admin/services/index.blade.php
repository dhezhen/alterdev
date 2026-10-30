@extends('admin.layout')

@section('title', 'Layanan')

@section('content')
<div class="page-head">
    <div><h1>Layanan</h1><p>Layanan yang tampil di beranda dan halaman Layanan.</p></div>
    <a href="{{ route('admin.services.create') }}" class="btn btn-primary"><x-icon name="plus" size="16" stroke="2.2" />Tambah Layanan</a>
</div>

<div class="table-wrap">
    <table>
        <thead><tr><th>Urutan</th><th>Layanan</th><th>Status</th><th style="width: 1%">Aksi</th></tr></thead>
        <tbody>
        @forelse ($services as $service)
            <tr>
                <td>{{ $service->sort_order }}</td>
                <td>
                    <strong>{{ $service->title }}</strong>
                    <span class="sub">{{ \Illuminate\Support\Str::limit($service->short_description, 110) }}</span>
                </td>
                <td><span class="badge {{ $service->is_active ? 'b-on' : 'b-off' }}">{{ $service->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                <td>
                    <div class="actions">
                        @if ($service->is_active)<a href="{{ route('services.show', $service) }}" target="_blank" class="btn btn-light btn-sm" title="Lihat"><x-icon name="eye" size="15" stroke="2" /></a>@endif
                        <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-light btn-sm"><x-icon name="edit" size="15" stroke="2" />Ubah</a>
                        <x-admin.delete :action="route('admin.services.destroy', $service)" />
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="4" class="empty">Belum ada layanan.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
