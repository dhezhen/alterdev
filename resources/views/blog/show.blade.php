@extends('layouts.app')

@section('title', $post->title)
@section('description', $post->excerptText())
@if ($post->cover_image)
    @section('og_image', $post->coverUrl())
@endif

@section('content')
<article class="section" style="padding-top: 56px">
    <div class="container">
        <div class="article stack" style="gap: 22px">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Beranda</a><span aria-hidden="true">/</span>
                <a href="{{ route('blog.index') }}">Blog</a>
                @if ($post->category)<span aria-hidden="true">/</span><a href="{{ route('blog.index', ['kategori' => $post->category]) }}">{{ $post->category }}</a>@endif
            </nav>
            <h1 class="title-lg" style="font-size: clamp(30px, 5vw, 44px)">{{ $post->title }}</h1>
            <div class="meta">
                <span>{{ $post->published_at->translatedFormat('l, j F Y') }}</span>
                <span>{{ $post->readingMinutes() }} menit baca</span>
                @if ($post->author)<span>Oleh {{ $post->author->name }}</span>@endif
            </div>
            @if ($post->cover_image)
                <div class="cover"><img src="{{ $post->coverUrl() }}" alt=""></div>
            @endif
            <div class="glass prose" style="border-radius: 28px; padding: 40px">
                {!! $post->bodyHtml() !!}
            </div>
            <div class="neu" style="border-radius: 24px; padding: 28px; display: flex; flex-wrap: wrap; gap: 18px; align-items: center; justify-content: space-between">
                <div class="stack" style="gap: 6px; flex: 1 1 320px">
                    <strong style="font-size: 18px">Butuh bantuan menerapkannya?</strong>
                    <span class="small">Konsultasikan kebutuhan Anda dengan tim kami — gratis.</span>
                </div>
                <a href="{{ route('contact') }}" class="btn btn-primary btn-sm">Konsultasi Gratis</a>
            </div>
        </div>
    </div>
</article>

@if ($related->isNotEmpty())
<section class="section">
    <div class="container">
        <div class="section-head"><h2 class="title-lg">Artikel lainnya</h2></div>
        <div class="grid grid-3">
            @foreach ($related as $post)
                @include('partials.post-card')
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
