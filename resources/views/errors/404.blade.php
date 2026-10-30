@extends('layouts.app')

@section('title', 'Halaman tidak ditemukan')

@section('content')
<section class="section" style="padding-top: 80px">
    <div class="container" style="max-width: 680px">
        <div class="box glass stack" style="text-align: center; align-items: center; gap: 20px">
            <span class="accent" style="font-size: 72px; font-weight: 800; line-height: 1">404</span>
            <h1 class="title-md">Halaman yang Anda cari tidak ditemukan</h1>
            <p class="text">Mungkin tautannya sudah berubah atau halaman telah dihapus.</p>
            <div style="display: flex; flex-wrap: wrap; gap: 12px; justify-content: center">
                <a href="{{ route('home') }}" class="btn btn-primary btn-sm">Ke Beranda</a>
                <a href="{{ route('contact') }}" class="btn btn-soft btn-sm">Hubungi Kami</a>
            </div>
        </div>
    </div>
</section>
@endsection
