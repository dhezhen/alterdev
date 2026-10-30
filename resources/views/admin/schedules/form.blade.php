@extends('admin.layout')

@section('title', $schedule->exists ? 'Ubah Jadwal' : 'Tambah Jadwal')

@section('content')
<div class="page-head">
    <div>
        <h1>{{ $schedule->exists ? 'Ubah Jadwal' : 'Tambah Jadwal' }}</h1>
        <p>{{ $training->title }}</p>
    </div>
    <a href="{{ $schedule->exists ? route('admin.schedules.show', $schedule) : route('admin.trainings.edit', $training) }}" class="btn btn-light"><x-icon name="arrow-left" size="16" stroke="2" />Kembali</a>
</div>

<form method="POST" action="{{ $schedule->exists ? route('admin.schedules.update', $schedule) : route('admin.schedules.store', $training) }}" class="split">
    @csrf
    @if ($schedule->exists) @method('PUT') @endif

    <div class="main-col panel form">
        <x-admin.input name="batch_name" label="Nama angkatan / kelas" :value="$schedule->batch_name" required placeholder="Angkatan 1 — Kelas Guru" />
        <div class="form-row">
            <x-admin.input name="start_date" label="Tanggal mulai" type="date" :value="$schedule->start_date?->format('Y-m-d')" required />
            <x-admin.input name="end_date" label="Tanggal selesai" type="date" :value="$schedule->end_date?->format('Y-m-d')" hint="Kosongkan bila hanya satu hari." />
        </div>
        <div class="form-row">
            <x-admin.input name="time_info" label="Waktu" :value="$schedule->time_info" placeholder="08.00 – 15.00 WIB" />
            <x-admin.select name="mode" label="Pelaksanaan" :options="\App\Models\TrainingSchedule::MODES" :value="$schedule->mode" required />
        </div>
        <x-admin.input name="location" label="Lokasi / tautan" :value="$schedule->location" placeholder="Nama tempat, alamat, atau 'Zoom (tautan dikirim via email)'" />
        <x-admin.textarea name="notes" label="Catatan untuk peserta" :value="$schedule->notes" rows="3" hint="Tampil di halaman pelatihan, misalnya: bawa laptop." />
    </div>

    <div class="side-col">
        <div class="panel form">
            <x-admin.input name="quota" label="Kuota peserta" type="number" min="1" :value="$schedule->quota" required />
            <x-admin.input name="price" label="Biaya (Rp)" type="number" min="0" step="1000" :value="$schedule->price" required hint="Isi 0 untuk pelatihan gratis." />
            <x-admin.input name="registration_deadline" label="Batas pendaftaran" type="date" :value="$schedule->registration_deadline?->format('Y-m-d')" />
            <x-admin.select name="status" label="Status" :options="\App\Models\TrainingSchedule::STATUSES" :value="$schedule->status" required />
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Simpan</button>
            @if ($schedule->exists)
                <x-admin.delete :action="route('admin.schedules.destroy', $schedule)" label="Hapus" />
            @endif
        </div>
    </div>
</form>
@endsection
