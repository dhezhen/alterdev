@extends('admin.layout')

@section('title', 'Dasbor')

@section('content')
<div class="page-head">
    <div>
        <h1>Assalamu'alaikum, {{ \Illuminate\Support\Str::before(auth()->user()->name, ' ') }}</h1>
        <p>Ringkasan aktivitas website hari ini.</p>
    </div>
    <div class="actions">
        <a href="{{ route('admin.posts.create') }}" class="btn btn-light"><x-icon name="pen" size="16" stroke="2" />Tulis Artikel</a>
        <a href="{{ route('admin.trainings.index') }}" class="btn btn-primary"><x-icon name="plus" size="16" stroke="2.2" />Jadwal Pelatihan</a>
    </div>
</div>

<div class="grid grid-stats" style="margin-bottom: 20px">
    @foreach ($stats as [$label, $value, $icon, $url])
        <a href="{{ $url }}" class="panel stat">
            <span class="ic"><x-icon :name="$icon" size="22" stroke="2" /></span>
            <span><strong>{{ $value }}</strong><span>{{ $label }}</span></span>
        </a>
    @endforeach
</div>

<div class="grid grid-2">
    <section class="panel">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px">
            <h2 style="margin: 0">Pesan masuk terbaru</h2>
            <a href="{{ route('admin.messages.index') }}" class="btn btn-light btn-sm">Semua</a>
        </div>
        @forelse ($messages as $message)
            <a href="{{ route('admin.messages.show', $message) }}" style="display: flex; justify-content: space-between; gap: 12px; padding: 10px 0; border-bottom: 1px solid var(--line); text-decoration: none; color: var(--ink)">
                <span style="min-width: 0">
                    <strong @if (! $message->read_at) style="color: var(--accent)" @endif>{{ $message->name }}</strong>
                    <span style="display: block; color: var(--muted); font-size: 13px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis">{{ $message->service ?: \Illuminate\Support\Str::limit($message->message, 60) }}</span>
                </span>
                <span style="text-align: right; flex: none">
                    <span class="badge b-{{ $message->status }}">{{ $message->statusLabel() }}</span>
                    <span style="display: block; color: var(--muted); font-size: 12px; margin-top: 4px">{{ $message->created_at->diffForHumans() }}</span>
                </span>
            </a>
        @empty
            <p class="empty">Belum ada pesan masuk.</p>
        @endforelse
    </section>

    <section class="panel">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px">
            <h2 style="margin: 0">Pendaftar pelatihan terbaru</h2>
            <a href="{{ route('admin.registrations.index') }}" class="btn btn-light btn-sm">Semua</a>
        </div>
        @forelse ($registrations as $registration)
            <a href="{{ route('admin.registrations.show', $registration) }}" style="display: flex; justify-content: space-between; gap: 12px; padding: 10px 0; border-bottom: 1px solid var(--line); text-decoration: none; color: var(--ink)">
                <span style="min-width: 0">
                    <strong>{{ $registration->name }}</strong>
                    <span style="display: block; color: var(--muted); font-size: 13px">{{ $registration->schedule->training->title }} · {{ $registration->schedule->batch_name }}</span>
                </span>
                <span style="text-align: right; flex: none">
                    <span class="badge b-{{ $registration->status }}">{{ $registration->statusLabel() }}</span>
                    <span style="display: block; color: var(--muted); font-size: 12px; margin-top: 4px">{{ $registration->created_at->diffForHumans() }}</span>
                </span>
            </a>
        @empty
            <p class="empty">Belum ada pendaftar.</p>
        @endforelse
    </section>

    <section class="panel">
        <h2>Jadwal pelatihan mendatang</h2>
        @forelse ($upcoming as $schedule)
            <a href="{{ route('admin.schedules.show', $schedule) }}" style="display: flex; justify-content: space-between; gap: 12px; padding: 10px 0; border-bottom: 1px solid var(--line); text-decoration: none; color: var(--ink)">
                <span><strong>{{ $schedule->training->title }}</strong><span style="display: block; color: var(--muted); font-size: 13px">{{ $schedule->dateLabel() }} · {{ $schedule->modeLabel() }}</span></span>
                <span style="flex: none; font-weight: 700">{{ $schedule->registrations_count }}/{{ $schedule->quota }}</span>
            </a>
        @empty
            <p class="empty">Belum ada jadwal mendatang.</p>
        @endforelse
    </section>

    <section class="panel">
        <h2>Pesan masuk 6 bulan terakhir</h2>
        @php $max = max(1, collect($messagesPerMonth)->max('count')); @endphp
        <div class="chart" role="img" aria-label="Grafik jumlah pesan masuk per bulan">
            @foreach ($messagesPerMonth as $month)
                <div class="bar">
                    <b>{{ $month['count'] }}</b>
                    <span class="v" style="height: {{ max(3, round($month['count'] / $max * 96)) }}px"></span>
                    <small>{{ $month['label'] }}</small>
                </div>
            @endforeach
        </div>
    </section>
</div>
@endsection
