@extends('admin.layout')

@section('title', 'Pesan Masuk')

@section('content')
<div class="page-head">
    <div><h1>Pesan Masuk</h1><p>Permintaan konsultasi dari formulir kontak website.</p></div>
    <a href="{{ route('admin.messages.export', request()->only('status', 'q')) }}" class="btn btn-light"><x-icon name="download" size="16" stroke="2" />Unduh CSV</a>
</div>

<form method="GET" class="filters">
    <div class="tabs">
        <a href="{{ route('admin.messages.index', array_filter(['q' => $search])) }}" @class(['active' => ! $status])>Semua ({{ $counts->sum() }})</a>
        @foreach (\App\Models\Message::STATUSES as $key => $label)
            <a href="{{ route('admin.messages.index', array_filter(['status' => $key, 'q' => $search])) }}" @class(['active' => $status === $key])>{{ $label }} ({{ $counts[$key] ?? 0 }})</a>
        @endforeach
    </div>
    @if ($status)<input type="hidden" name="status" value="{{ $status }}">@endif
    <input type="search" name="q" value="{{ $search }}" class="input" placeholder="Cari nama, kontak, isi pesan…" style="max-width: 280px" aria-label="Cari pesan">
    <button class="btn btn-light">Cari</button>
</form>

<div class="table-wrap">
    <table>
        <thead><tr><th>Tanggal</th><th>Pengirim</th><th>Kebutuhan</th><th>Status</th><th style="width: 1%">Aksi</th></tr></thead>
        <tbody>
        @forelse ($messages as $message)
            <tr @class(['unread' => ! $message->read_at])>
                <td>{{ $message->created_at->format('d/m/Y') }}<span class="sub">{{ $message->created_at->format('H:i') }}</span></td>
                <td>{{ $message->name }}<span class="sub">{{ $message->email ?? $message->phone }}{{ $message->institution ? ' · '.$message->institution : '' }}</span></td>
                <td>{{ $message->service ?: '—' }}<span class="sub">{{ \Illuminate\Support\Str::limit($message->message, 90) }}</span></td>
                <td><span class="badge b-{{ $message->status }}">{{ $message->statusLabel() }}</span></td>
                <td><a href="{{ route('admin.messages.show', $message) }}" class="btn btn-light btn-sm">Buka</a></td>
            </tr>
        @empty
            <tr><td colspan="5" class="empty">Tidak ada pesan.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
{{ $messages->links() }}
@endsection
