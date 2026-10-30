@extends('layouts.app')

@section('title', 'Portofolio')
@section('description', 'Proyek website, sistem informasi, aplikasi, dan pelatihan IT yang telah kami kerjakan.')

@section('content')
@include('partials.page-hero', [
    'eyebrow' => 'Portofolio',
    'title' => 'Proyek yang telah kami kerjakan',
    'text' => 'Setiap proyek berangkat dari masalah nyata di lapangan. Klik untuk melihat cerita lengkapnya.',
    'crumbs' => ['Portofolio' => null],
])

<section class="section" style="padding-top: 0">
    <div class="container">
        <nav class="filter neu-in" aria-label="Saring proyek berdasarkan kategori" style="display: inline-flex; margin-bottom: 36px">
            <a href="{{ route('portfolios.index') }}" @class(['active' => ! $activeCategory])>Semua</a>
            @foreach ($categories as $cat)
                <a href="{{ route('portfolios.index', ['kategori' => $cat]) }}" @class(['active' => $activeCategory === $cat])>{{ $cat }}</a>
            @endforeach
        </nav>

        @if ($portfolios->isEmpty())
            <div class="empty neu-in">Belum ada proyek pada kategori ini.</div>
        @else
            <div class="grid grid-3">
                @foreach ($portfolios as $portfolio)
                    @include('partials.project-card')
                @endforeach
            </div>
            {{ $portfolios->links() }}
        @endif
    </div>
</section>

@include('partials.cta', ['title' => 'Ingin proyek Anda ada di sini berikutnya?'])
@endsection
