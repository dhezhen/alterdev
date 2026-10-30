{{-- Judul halaman dalam. Variabel: $eyebrow, $title, $text (opsional), $crumbs (array label => url) --}}
<section class="page-hero">
    <div class="container">
        @isset($crumbs)
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Beranda</a>
                @foreach ($crumbs as $label => $url)
                    <span aria-hidden="true">/</span>
                    @if ($url)
                        <a href="{{ $url }}">{{ $label }}</a>
                    @else
                        <span aria-current="page">{{ $label }}</span>
                    @endif
                @endforeach
            </nav>
        @endisset
        <div class="stack" style="max-width: 760px">
            @isset($eyebrow)<span class="eyebrow">{{ $eyebrow }}</span>@endisset
            <h1 class="title-lg" style="font-size: clamp(32px, 5vw, 46px)">{{ $title }}</h1>
            @isset($text)<p class="lead">{{ $text }}</p>@endisset
        </div>
    </div>
</section>
