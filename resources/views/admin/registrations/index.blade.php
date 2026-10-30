@extends('admin.layout')

@section('title', 'Pendaftar Pelatihan')

@section('content')
<div class="page-head">
    <div><h1>Pendaftar Pelatihan</h1><p>Semua pendaftaran dari website. Ubah status untuk konfirmasi peserta.</p></div>
</div>

<form method="GET" class="filters">
    <div class="tabs">
        <a href="{{ route('admin.registrations.index', array_filter(['q' => $search])) }}" @class(['active' => ! $status])>Semua</a>
        @foreach (\App\Models\TrainingRegistration::STATUSES as $key => $label)
            <a href="{{ route('admin.registrations.index', array_filter(['status' => $key, 'q' => $search])) }}" @class(['active' => $status === $key])>{{ $label }}</a>
        @endforeach
    </div>
    @if ($status)<input type="hidden" name="status" value="{{ $status }}">@endif
    <input type="search" name="q" value="{{ $search }}" class="input" placeholder="Nama, email, kode, instansi…" style="max-width: 280px" aria-label="Cari pendaftar">
    <button class="btn btn-light">Cari</button>
</form>

<div class="table-wrap">
    <table>
        <thead><tr><th>Tanggal</th><th>Peserta</th><th>Pelatihan</th><th>Status</th><th style="width: 1%">Aksi</th></tr></thead>
        <tbody>
        @forelse ($registrations as $registration)
            <tr>
                <td>{{ $registration->created_at->format('d/m/Y') }}<span class="sub">{{ $registration->created_at->format('H:i') }}</span></td>
                <td><strong>{{ $registration->name }}</strong><span class="sub">{{ $registration->code }} · {{ $registration->phone }}</span></td>
                <td>{{ $registration->schedule->training->title }}<span class="sub">{{ $registration->schedule->batch_name }} · {{ $registration->schedule->dateLabel() }}</span></td>
                <td><span class="badge b-{{ $registration->status }}">{{ $registration->statusLabel() }}</span></td>
                <td><a href="{{ route('admin.registrations.show', $registration) }}" class="btn btn-light btn-sm">Detail</a></td>
            </tr>
        @empty
            <tr><td colspan="5" class="empty">Tidak ada pendaftar.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
{{ $registrations->links() }}
@endsection
