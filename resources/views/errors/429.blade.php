@extends('layouts.app')

@section('title', 'Terlalu banyak permintaan')

@section('content')
<section class="section" style="padding-top: 80px">
    <div class="container" style="max-width: 680px">
        <div class="box glass stack" style="text-align: center; align-items: center; gap: 20px">
            <span class="accent" style="font-size: 64px; font-weight: 800; line-height: 1">429</span>
            <h1 class="title-md">Mohon tunggu sebentar</h1>
            <p class="text">Anda mengirim terlalu banyak permintaan dalam waktu singkat. Silakan coba lagi dalam satu menit.</p>
            <a href="{{ route('home') }}" class="btn btn-primary btn-sm">Kembali ke Beranda</a>
        </div>
    </div>
</section>
@endsection
