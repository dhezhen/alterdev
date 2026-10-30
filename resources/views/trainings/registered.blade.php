@extends('layouts.app')

@section('title', 'Pendaftaran Diterima')

@push('head')<meta name="robots" content="noindex">@endpush

@section('content')
@php $schedule = $registration->schedule; @endphp
<section class="section" style="padding-top: 64px">
    <div class="container" style="max-width: 760px">
        <div class="box glass stack" style="gap: 22px; text-align: center; align-items: center">
            <span class="neu" style="width: 76px; height: 76px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #1F9D55"><x-icon name="check" size="36" stroke="2.6" /></span>
            <h1 class="title-lg">Terima kasih, {{ $registration->name }}!</h1>
            <p class="lead">Pendaftaran Anda untuk <strong>{{ $schedule->training->title }}</strong> sudah kami terima. Tim kami akan menghubungi Anda melalui WhatsApp atau email untuk konfirmasi.</p>

            <div class="neu-in" style="border-radius: 22px; padding: 24px; width: 100%; text-align: left">
                <dl style="margin: 0; display: grid; grid-template-columns: auto 1fr; gap: 10px 18px; font-size: 15px">
                    <dt class="small">Kode pendaftaran</dt><dd style="margin: 0; font-weight: 800; letter-spacing: .04em" class="accent">{{ $registration->code }}</dd>
                    <dt class="small">Jadwal</dt><dd style="margin: 0; font-weight: 600">{{ $schedule->batch_name }} — {{ $schedule->dateLabel() }}</dd>
                    <dt class="small">Pelaksanaan</dt><dd style="margin: 0; font-weight: 600">{{ $schedule->modeLabel() }}@if ($schedule->location), {{ $schedule->location }}@endif</dd>
                    <dt class="small">Biaya</dt><dd style="margin: 0; font-weight: 600">{{ $schedule->priceLabel() }}</dd>
                    <dt class="small">Status</dt><dd style="margin: 0; font-weight: 600">{{ $registration->statusLabel() }}</dd>
                </dl>
            </div>
            <p class="small">Simpan kode pendaftaran di atas. Halaman ini bisa Anda buka kembali untuk melihat status pendaftaran.</p>
            <div style="display: flex; flex-wrap: wrap; gap: 12px; justify-content: center">
                <a href="{{ route('trainings.index') }}" class="btn btn-soft btn-sm">Pelatihan Lainnya</a>
                <a href="{{ route('home') }}" class="btn btn-primary btn-sm">Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</section>
@endsection
