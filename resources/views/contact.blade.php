@extends('layouts.app')

@section('title', 'Kontak')
@section('description', 'Hubungi kami untuk konsultasi gratis pembuatan website, sistem informasi, aplikasi, atau pelatihan IT.')

@section('content')
@include('partials.page-hero', [
    'eyebrow' => 'Hubungi Kami',
    'title' => 'Punya ide atau kendala? Yuk, kita bicarakan.',
    'text' => 'Tidak perlu menyiapkan dokumen teknis. Ceritakan saja apa yang ingin Anda capai — kami yang bantu menerjemahkannya menjadi solusi. Konsultasi awal gratis.',
    'crumbs' => ['Kontak' => null],
])

<section class="section" style="padding-top: 0" id="kontak">
    <div class="container">
        <div class="box glass row" style="align-items: flex-start">
            <div class="stack" style="flex-basis: 340px">
                <strong style="font-size: 20px">Informasi kontak</strong>
                <p class="text">Anda juga bisa langsung menghubungi kami melalui WhatsApp atau email di bawah ini.</p>
                @include('partials.contact-info')
            </div>
            <div style="flex: 1.2 1 400px">
                @include('partials.contact-form')
            </div>
        </div>
    </div>
</section>
@endsection
