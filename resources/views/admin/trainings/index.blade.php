@extends('admin.layout')

@section('title', 'Program Pelatihan')

@section('content')
<div class="page-head">
    <div><h1>Program Pelatihan</h1><p>Kelola program, lalu tambahkan jadwal pada masing-masing program.</p></div>
    <a href="{{ route('admin.trainings.create') }}" class="btn btn-primary"><x-icon name="plus" size="16" stroke="2.2" />Tambah Program</a>
</div>

<div class="table-wrap">
    <table>
        <thead><tr><th>Urutan</th><th>Program</th><th>Jadwal</th><th>Status</th><th style="width: 1%">Aksi</th></tr></thead>
        <tbody>
        @forelse ($trainings as $training)
            <tr>
                <td>{{ $training->sort_order }}</td>
                <td><strong>{{ $training->title }}</strong><span class="sub">{{ collect([$training->duration, $training->audience])->filter()->implode(' · ') }}</span></td>
                <td>{{ $training->upcoming_schedules_count }} dibuka<span class="sub">{{ $training->schedules_count }} total</span></td>
                <td><span class="badge {{ $training->is_active ? 'b-on' : 'b-off' }}">{{ $training->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                <td>
                    <div class="actions">
                        <a href="{{ route('admin.schedules.create', $training) }}" class="btn btn-light btn-sm"><x-icon name="calendar" size="15" stroke="2" />Jadwal</a>
                        <a href="{{ route('admin.trainings.edit', $training) }}" class="btn btn-light btn-sm"><x-icon name="edit" size="15" stroke="2" />Ubah</a>
                        <x-admin.delete :action="route('admin.trainings.destroy', $training)" confirm="Hapus program ini beserta seluruh jadwalnya?" />
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="empty">Belum ada program pelatihan.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
