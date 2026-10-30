@extends('layouts.app')

@section('title', 'Blog')
@section('description', 'Tips, panduan, dan wawasan seputar website, sistem informasi, aplikasi, dan literasi digital.')

@section('content')
@include('partials.page-hero', [
    'eyebrow' => 'Blog',
    'title' => 'Tips & wawasan teknologi',
    'text' => 'Panduan praktis seputar website, sistem informasi, aplikasi, dan literasi digital — ditulis dengan bahasa yang mudah dipahami.',
    'crumbs' => ['Blog' => null],
])

<section class="section" style="padding-top: 0">
    <div class="container">
        <div style="display: flex; flex-wrap: wrap; gap: 16px; justify-content: space-between; align-items: center; margin-bottom: 36px">
            <nav class="filter neu-in" aria-label="Kategori artikel">
                <a href="{{ route('blog.index', array_filter(['cari' => $search])) }}" @class(['active' => ! $activeCategory])>Semua</a>
                @foreach ($categories as $cat)
                    <a href="{{ route('blog.index', array_filter(['kategori' => $cat, 'cari' => $search])) }}" @class(['active' => $activeCategory === $cat])>{{ $cat }}</a>
                @endforeach
            </nav>
            <form method="GET" action="{{ route('blog.index') }}" role="search" style="display: flex; gap: 10px; flex: 0 1 360px">
                @if ($activeCategory)<input type="hidden" name="kategori" value="{{ $activeCategory }}">@endif
                <label class="hp" for="cari">Cari artikel</label>
                <input id="cari" class="input" type="search" name="cari" value="{{ $search }}" placeholder="Cari artikel…">
                <button class="btn btn-primary btn-sm" type="submit" aria-label="Cari"><x-icon name="search" size="18" stroke="2" /></button>
            </form>
        </div>

        @if ($posts->isEmpty())
            <div class="empty neu-in">Belum ada artikel{{ $search ? ' yang cocok dengan pencarian "'.$search.'"' : '' }}.</div>
        @else
            <div class="grid grid-3">
                @foreach ($posts as $post)
                    @include('partials.post-card')
                @endforeach
            </div>
            {{ $posts->links() }}
        @endif
    </div>
</section>
@endsection
