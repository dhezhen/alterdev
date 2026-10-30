@extends('layouts.app')

@section('title', 'Pelatihan IT')
@section('description', 'Program pelatihan IT yang praktis untuk guru, staf, UMKM, mahasiswa, dan aparatur desa. Lihat jadwal dan daftar online.')

@section('content')
@include('partials.page-hero', [
    'eyebrow' => 'Program Pelatihan IT',
    'title' => 'Belajar teknologi tanpa takut, langsung bisa dipraktikkan',
    'text' => 'Pilih program yang sesuai, lalu daftar pada jadwal terdekat. Ingin pelatihan khusus di lembaga Anda? Kami juga melayani in-house training.',
    'crumbs' => ['Pelatihan' => null],
])

<section class="section" style="padding-top: 0">
    <div class="container">
        <div class="section-head">
            <span class="eyebrow">Jadwal Terdekat</span>
            <h2 class="title-lg">Pendaftaran yang sedang dibuka</h2>
        </div>

        @if ($schedules->isEmpty())
            <div class="empty neu-in">
                Belum ada jadwal yang dibuka saat ini. <a href="{{ route('contact', ['layanan' => 'Pelatihan IT']) }}">Hubungi kami</a> untuk mengajukan pelatihan di lembaga Anda.
            </div>
        @else
            <div class="grid grid-2">
                @foreach ($schedules as $schedule)
                    @include('trainings.partials.schedule', ['showTraining' => true])
                @endforeach
            </div>
        @endif
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head">
            <span class="eyebrow">Program</span>
            <h2 class="title-lg">Semua program pelatihan</h2>
        </div>
        <div class="grid grid-3">
            @foreach ($trainings as $training)
                <a href="{{ route('trainings.show', $training) }}" class="card neu">
                    <span class="icon-box neu-in"><x-icon :name="$training->icon" size="26" stroke="1.8" /></span>
                    <h3>{{ $training->title }}</h3>
                    <p class="small" style="line-height: 1.65; color: var(--muted)">{{ $training->summary }}</p>
                    <div class="meta" style="margin-top: auto">
                        @if ($training->duration)<span>{{ $training->duration }}</span>@endif
                        <span>{{ $training->upcoming_schedules_count > 0 ? $training->upcoming_schedules_count.' jadwal tersedia' : 'Jadwal menyusul' }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

@include('partials.cta', [
    'title' => 'Ingin pelatihan khusus untuk tim Anda?',
    'text' => 'Kami bisa menyelenggarakan pelatihan di lokasi Anda dengan materi yang disesuaikan kebutuhan peserta.',
])
@endsection
