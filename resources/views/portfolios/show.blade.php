@extends('layouts.app')

@section('title', $portfolio->title)
@section('description', $portfolio->summary)
@if ($portfolio->image)
    @section('og_image', $portfolio->imageUrl())
@endif

@section('content')
@include('partials.page-hero', [
    'eyebrow' => $portfolio->category,
    'title' => $portfolio->title,
    'text' => $portfolio->summary,
    'crumbs' => ['Portofolio' => route('portfolios.index'), $portfolio->title => null],
])

<section class="section" style="padding-top: 0">
    <div class="container layout-side">
        <div class="main stack" style="gap: 28px">
            <div class="project-thumb glass {{ $portfolio->image ? '' : 'tint-'.($portfolio->id % 5) }}" style="height: auto; aspect-ratio: 16/9; border-radius: 26px">
                @if ($portfolio->image)
                    <img src="{{ $portfolio->imageUrl() }}" alt="Tampilan {{ $portfolio->title }}">
                @else
                    <div class="mock" style="padding: 22px" role="img" aria-label="Ilustrasi {{ $portfolio->title }}">
                        <div class="window-dots" aria-hidden="true"><span></span><span></span><span></span></div>
                        <div class="mock-body" aria-hidden="true">
                            <div class="mock-side"><span></span><span></span><span></span><span></span></div>
                            <div class="mock-main">
                                <div class="mock-title" style="font-size: 15px">{{ $portfolio->title }}</div>
                                <div class="mock-cells"><span></span><span></span><span></span></div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            @foreach (['challenge' => 'Tantangan', 'solution' => 'Solusi', 'result' => 'Hasil'] as $field => $label)
                @if ($portfolio->$field)
                    <div class="neu" style="border-radius: 24px; padding: 30px">
                        <span class="eyebrow">{{ $label }}</span>
                        <div class="prose" style="margin-top: 10px">{!! \Illuminate\Support\Str::markdown($portfolio->$field, ['html_input' => 'strip', 'allow_unsafe_links' => false]) !!}</div>
                    </div>
                @endif
            @endforeach
        </div>

        <aside class="side">
            <div class="glass" style="border-radius: 26px; padding: 28px; display: flex; flex-direction: column; gap: 16px">
                <strong style="font-size: 17px">Ringkasan Proyek</strong>
                <dl style="margin: 0; display: grid; grid-template-columns: auto 1fr; gap: 10px 16px; font-size: 14.5px">
                    <dt class="small">Kategori</dt><dd style="margin: 0; font-weight: 600">{{ $portfolio->category }}</dd>
                    @if ($portfolio->client)<dt class="small">Klien</dt><dd style="margin: 0; font-weight: 600">{{ $portfolio->client }}</dd>@endif
                    @if ($portfolio->year)<dt class="small">Tahun</dt><dd style="margin: 0; font-weight: 600">{{ $portfolio->year }}</dd>@endif
                </dl>
                @if ($portfolio->tags)
                    <div class="tags">@foreach ($portfolio->tags as $tag)<span class="tag">{{ $tag }}</span>@endforeach</div>
                @endif
                @if ($portfolio->url)
                    <a href="{{ $portfolio->url }}" target="_blank" rel="noopener" class="btn btn-soft btn-sm">Kunjungi Proyek <x-icon name="external" size="16" stroke="2" /></a>
                @endif
                <a href="{{ route('contact') }}" class="btn btn-primary btn-sm">Buat Proyek Serupa</a>
            </div>
        </aside>
    </div>
</section>

@if ($others->isNotEmpty())
<section class="section">
    <div class="container">
        <div class="section-head"><h2 class="title-lg">Proyek lain di kategori ini</h2></div>
        <div class="grid grid-3">
            @foreach ($others as $portfolio)
                @include('partials.project-card')
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
