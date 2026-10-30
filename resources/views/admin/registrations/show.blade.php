@extends('admin.layout')

@section('title', 'Pendaftar '.$registration->name)

@section('content')
@php
    $schedule = $registration->schedule;
    $phone = preg_replace('/\D/', '', $registration->phone);
    if (str_starts_with($phone, '0')) { $phone = '62'.substr($phone, 1); }
    $waText = "Assalamu'alaikum {$registration->name}, terima kasih telah mendaftar {$schedule->training->title} ({$schedule->batch_name}) pada {$schedule->dateLabel()}. Kode pendaftaran Anda: {$registration->code}.";
@endphp
<div class="page-head">
    <div><h1>{{ $registration->name }}</h1><p>Kode {{ $registration->code }} · didaftarkan {{ $registration->created_at->translatedFormat('j F Y, H:i') }}</p></div>
    <a href="{{ route('admin.schedules.show', $schedule) }}" class="btn btn-light"><x-icon name="arrow-left" size="16" stroke="2" />Daftar peserta</a>
</div>

<div class="split">
    <div class="main-col">
        <section class="panel">
            <h2>Data peserta</h2>
            <dl class="meta">
                <dt>Nama</dt><dd>{{ $registration->name }}</dd>
                <dt>Email</dt><dd><a href="mailto:{{ $registration->email }}">{{ $registration->email }}</a></dd>
                <dt>HP / WhatsApp</dt><dd>{{ $registration->phone }}</dd>
                <dt>Instansi</dt><dd>{{ $registration->institution ?: '—' }}</dd>
                <dt>Catatan peserta</dt><dd>{{ $registration->notes ?: '—' }}</dd>
            </dl>
        </section>
        <section class="panel">
            <h2>Pelatihan</h2>
            <dl class="meta">
                <dt>Program</dt><dd>{{ $schedule->training->title }}</dd>
                <dt>Angkatan</dt><dd>{{ $schedule->batch_name }}</dd>
                <dt>Tanggal</dt><dd>{{ $schedule->dateLabel() }} {{ $schedule->time_info }}</dd>
                <dt>Pelaksanaan</dt><dd>{{ $schedule->modeLabel() }}{{ $schedule->location ? ', '.$schedule->location : '' }}</dd>
                <dt>Biaya</dt><dd>{{ $schedule->priceLabel() }}</dd>
            </dl>
        </section>
    </div>

    <div class="side-col">
        <form method="POST" action="{{ route('admin.registrations.update', $registration) }}" class="panel form">
            @csrf @method('PUT')
            <h2 style="margin: 0">Tindak lanjut</h2>
            <x-admin.select name="status" label="Status" :options="\App\Models\TrainingRegistration::STATUSES" :value="$registration->status" />
            <x-admin.textarea name="admin_notes" label="Catatan internal" :value="$registration->admin_notes" rows="4" hint="Hanya terlihat oleh admin." />
            <button class="btn btn-primary">Simpan</button>
        </form>
        <div class="panel" style="display: flex; flex-direction: column; gap: 10px">
            @if (strlen($phone) >= 9)
                <a href="https://wa.me/{{ $phone }}?text={{ rawurlencode($waText) }}" target="_blank" rel="noopener" class="btn btn-light"><x-icon name="whatsapp" size="16" stroke="2" />Hubungi via WhatsApp</a>
            @endif
            <a href="mailto:{{ $registration->email }}?subject={{ rawurlencode('Pendaftaran '.$schedule->training->title) }}" class="btn btn-light"><x-icon name="mail" size="16" stroke="2" />Kirim Email</a>
            <x-admin.delete :action="route('admin.registrations.destroy', $registration)" label="Hapus pendaftar" />
        </div>
    </div>
</div>
@endsection
