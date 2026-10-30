@extends('admin.layout')

@section('title', 'Jadwal Pelatihan')

@section('content')
<div class="page-head">
    <div><h1>Jadwal Pelatihan</h1><p>Untuk menambah jadwal, buka program pelatihan lalu klik "Tambah Jadwal".</p></div>
    <a href="{{ route('admin.trainings.index') }}" class="btn btn-primary"><x-icon name="plus" size="16" stroke="2.2" />Tambah Jadwal</a>
</div>

<div class="filters">
    <div class="tabs">
        <a href="{{ route('admin.schedules.index', ['waktu' => 'mendatang']) }}" @class(['active' => $when === 'mendatang'])>Mendatang</a>
        <a href="{{ route('admin.schedules.index', ['waktu' => 'lampau']) }}" @class(['active' => $when === 'lampau'])>Sudah lewat</a>
        <a href="{{ route('admin.schedules.index', ['waktu' => 'semua']) }}" @class(['active' => $when === 'semua'])>Semua</a>
    </div>
</div>

<div class="table-wrap">
    <table>
        <thead><tr><th>Program</th><th>Tanggal</th><th>Pelaksanaan</th><th>Pendaftar</th><th>Status</th><th style="width: 1%">Aksi</th></tr></thead>
        <tbody>
        @forelse ($schedules as $schedule)
            <tr>
                <td><strong>{{ $schedule->training->title }}</strong><span class="sub">{{ $schedule->batch_name }}</span></td>
                <td>{{ $schedule->dateLabel() }}@if ($schedule->time_info)<span class="sub">{{ $schedule->time_info }}</span>@endif</td>
                <td>{{ $schedule->modeLabel() }}<span class="sub">{{ $schedule->location }}</span></td>
                <td><strong>{{ $schedule->registrations_count }}</strong> / {{ $schedule->quota }}</td>
                <td><span class="badge b-{{ $schedule->status }}">{{ \App\Models\TrainingSchedule::STATUSES[$schedule->status] }}</span></td>
                <td>
                    <div class="actions">
                        <a href="{{ route('admin.schedules.show', $schedule) }}" class="btn btn-light btn-sm"><x-icon name="users" size="15" stroke="2" />Peserta</a>
                        <a href="{{ route('admin.schedules.edit', $schedule) }}" class="btn btn-light btn-sm"><x-icon name="edit" size="15" stroke="2" /></a>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="empty">Tidak ada jadwal.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
{{ $schedules->links() }}
@endsection
