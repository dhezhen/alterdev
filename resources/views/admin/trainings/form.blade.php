@extends('admin.layout')

@section('title', $training->exists ? 'Ubah Program Pelatihan' : 'Tambah Program Pelatihan')

@section('content')
<div class="page-head">
    <div><h1>{{ $training->exists ? $training->title : 'Tambah Program Pelatihan' }}</h1></div>
    <div class="actions">
        @if ($training->exists && $training->is_active)<a href="{{ route('trainings.show', $training) }}" target="_blank" class="btn btn-light"><x-icon name="eye" size="16" stroke="2" />Lihat</a>@endif
        <a href="{{ route('admin.trainings.index') }}" class="btn btn-light"><x-icon name="arrow-left" size="16" stroke="2" />Kembali</a>
    </div>
</div>

<form method="POST" action="{{ $training->exists ? route('admin.trainings.update', $training) : route('admin.trainings.store') }}" class="split">
    @csrf
    @if ($training->exists) @method('PUT') @endif

    <div class="main-col panel form">
        <x-admin.input name="title" label="Judul program" :value="$training->title" required />
        <x-admin.textarea name="summary" label="Ringkasan" :value="$training->summary" rows="2" required hint="Maksimal 255 karakter." />
        <x-admin.textarea name="description" label="Deskripsi lengkap" :value="$training->description" rows="10" code hint="Mendukung Markdown." />
        <x-admin.textarea name="outcomes_text" label="Yang akan didapat peserta" :value="implode(PHP_EOL, $training->outcomes ?? [])" rows="4" hint="Satu baris satu poin." />
    </div>

    <div class="side-col">
        <div class="panel form">
            <x-admin.select name="icon" label="Ikon" :options="\App\Support\Icons::OPTIONS" :value="$training->icon" />
            <x-admin.input name="audience" label="Cocok untuk" :value="$training->audience" placeholder="Guru, staf, UMKM" />
            <x-admin.input name="duration" label="Durasi" :value="$training->duration" placeholder="2 hari" />
            <x-admin.input name="slug" label="Slug URL" :value="$training->slug" hint="Kosongkan untuk dibuat otomatis." />
            <x-admin.input name="sort_order" label="Urutan tampil" type="number" min="0" :value="$training->sort_order ?? 0" />
            <x-admin.checkbox name="is_active" label="Tampilkan di website" :checked="$training->is_active" />
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.trainings.index') }}" class="btn btn-light">Batal</a>
        </div>
    </div>
</form>

@if ($training->exists)
    <section class="panel" style="margin-top: 20px">
        <div style="display: flex; flex-wrap: wrap; gap: 10px; justify-content: space-between; align-items: center; margin-bottom: 14px">
            <h2 style="margin: 0">Jadwal program ini</h2>
            <a href="{{ route('admin.schedules.create', $training) }}" class="btn btn-primary btn-sm"><x-icon name="plus" size="15" stroke="2.2" />Tambah Jadwal</a>
        </div>
        <div class="table-wrap">
            <table>
                <thead><tr><th>Angkatan</th><th>Tanggal</th><th>Pendaftar</th><th>Status</th><th style="width: 1%">Aksi</th></tr></thead>
                <tbody>
                @forelse ($training->schedules as $schedule)
                    <tr>
                        <td><strong>{{ $schedule->batch_name }}</strong><span class="sub">{{ $schedule->modeLabel() }}{{ $schedule->location ? ' · '.$schedule->location : '' }}</span></td>
                        <td>{{ $schedule->dateLabel() }}</td>
                        <td>{{ $schedule->registrations_count }} / {{ $schedule->quota }}</td>
                        <td><span class="badge b-{{ $schedule->status }}">{{ \App\Models\TrainingSchedule::STATUSES[$schedule->status] }}</span></td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('admin.schedules.show', $schedule) }}" class="btn btn-light btn-sm"><x-icon name="users" size="15" stroke="2" />Peserta</a>
                                <a href="{{ route('admin.schedules.edit', $schedule) }}" class="btn btn-light btn-sm"><x-icon name="edit" size="15" stroke="2" /></a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="empty">Belum ada jadwal.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endif
@endsection
