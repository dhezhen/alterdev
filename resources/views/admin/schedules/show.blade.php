@extends('admin.layout')

@section('title', 'Peserta '.$schedule->training->title)

@section('content')
<div class="page-head">
    <div>
        <h1>{{ $schedule->training->title }}</h1>
        <p>{{ $schedule->batch_name }} · {{ $schedule->dateLabel() }} · {{ $schedule->modeLabel() }}</p>
    </div>
    <div class="actions">
        <a href="{{ route('admin.schedules.export', $schedule) }}" class="btn btn-light"><x-icon name="download" size="16" stroke="2" />Unduh CSV</a>
        <a href="{{ route('admin.schedules.edit', $schedule) }}" class="btn btn-light"><x-icon name="edit" size="16" stroke="2" />Ubah Jadwal</a>
        <a href="{{ route('admin.trainings.edit', $schedule->training) }}" class="btn btn-light"><x-icon name="arrow-left" size="16" stroke="2" />Program</a>
    </div>
</div>

<div class="grid grid-stats" style="margin-bottom: 20px">
    <div class="panel stat"><span class="ic"><x-icon name="users" size="22" stroke="2" /></span><span><strong>{{ $schedule->filledSeats() }} / {{ $schedule->quota }}</strong><span>Kuota terisi</span></span></div>
    @foreach (\App\Models\TrainingRegistration::STATUSES as $key => $label)
        <a href="{{ route('admin.schedules.show', [$schedule, 'status' => $key]) }}" class="panel stat"><span class="ic"><x-icon name="user-plus" size="22" stroke="2" /></span><span><strong>{{ $counts[$key] ?? 0 }}</strong><span>{{ $label }}</span></span></a>
    @endforeach
</div>

<div class="filters">
    <div class="tabs">
        <a href="{{ route('admin.schedules.show', $schedule) }}" @class(['active' => ! request('status')])>Semua</a>
        @foreach (\App\Models\TrainingRegistration::STATUSES as $key => $label)
            <a href="{{ route('admin.schedules.show', [$schedule, 'status' => $key]) }}" @class(['active' => request('status') === $key])>{{ $label }}</a>
        @endforeach
    </div>
</div>

<div class="table-wrap">
    <table>
        <thead><tr><th>#</th><th>Peserta</th><th>Kontak</th><th>Status</th><th>Ubah status</th></tr></thead>
        <tbody>
        @forelse ($registrations as $i => $registration)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td><a href="{{ route('admin.registrations.show', $registration) }}"><strong>{{ $registration->name }}</strong></a><span class="sub">{{ $registration->code }}{{ $registration->institution ? ' · '.$registration->institution : '' }}</span></td>
                <td>{{ $registration->phone }}<span class="sub">{{ $registration->email }}</span></td>
                <td><span class="badge b-{{ $registration->status }}">{{ $registration->statusLabel() }}</span></td>
                <td>
                    <form method="POST" action="{{ route('admin.registrations.update', $registration) }}" class="actions">
                        @csrf @method('PUT')
                        <input type="hidden" name="admin_notes" value="{{ $registration->admin_notes }}">
                        <select name="status" class="input" style="min-height: 34px; padding: 4px 8px; width: auto" aria-label="Status {{ $registration->name }}">
                            @foreach (\App\Models\TrainingRegistration::STATUSES as $key => $label)
                                <option value="{{ $key }}" @selected($registration->status === $key)>{{ $label }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-light btn-sm">Simpan</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="empty">Belum ada pendaftar.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
