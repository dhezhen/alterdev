@extends('layouts.app')

@section('title', 'Sesi berakhir')

@section('content')
<section class="section" style="padding-top: 80px">
    <div class="container" style="max-width: 680px">
        <div class="box glass stack" style="text-align: center; align-items: center; gap: 20px">
            <span class="accent" style="font-size: 64px; font-weight: 800; line-height: 1">419</span>
            <h1 class="title-md">Sesi halaman sudah berakhir</h1>
            <p class="text">Halaman terbuka terlalu lama sehingga formulir tidak dapat dikirim. Muat ulang halaman, lalu kirim kembali.</p>
            <a href="{{ route('home') }}" class="btn btn-primary btn-sm">Kembali ke Beranda</a>
        </div>
    </div>
</section>
@endsection
