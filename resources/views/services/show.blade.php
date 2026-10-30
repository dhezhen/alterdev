@extends('layouts.app')

@section('title', $service->title)
@section('description', $service->short_description)

@section('content')
@include('partials.page-hero', [
    'eyebrow' => 'Layanan',
    'title' => $service->title,
    'text' => $service->short_description,
    'crumbs' => ['Layanan' => route('services.index'), $service->title => null],
])

<section class="section" style="padding-top: 0">
    <div class="container layout-side">
        <article class="main box glass prose" style="padding: 44px">
            {!! \Illuminate\Support\Str::markdown($service->description ?: $service->short_description, ['html_input' => 'strip', 'allow_unsafe_links' => false]) !!}
        </article>

        <aside class="side">
            <div class="neu" style="border-radius: 26px; padding: 28px; display: flex; flex-direction: column; gap: 16px">
                <span class="icon-box neu-in"><x-icon :name="$service->icon" size="26" stroke="1.8" /></span>
                <strong style="font-size: 18px">Tertarik dengan layanan ini?</strong>
                @if ($service->features)
                    <ul style="margin: 0; padding-left: 18px; font-size: 14px; line-height: 1.9; color: #3B4558">
                        @foreach ($service->features as $feature)<li>{{ $feature }}</li>@endforeach
                    </ul>
                @endif
                @if ($service->price_label)
                    <p class="small"><strong class="accent">{{ $service->price_label }}</strong></p>
                @endif
                <a href="{{ route('contact', ['layanan' => $service->title]) }}" class="btn btn-primary">Konsultasi Gratis</a>
            </div>
            @if ($others->isNotEmpty())
                <div class="neu-sm" style="border-radius: 22px; padding: 22px; display: flex; flex-direction: column; gap: 8px">
                    <strong style="font-size: 15px; margin-bottom: 4px">Layanan lainnya</strong>
                    @foreach ($others as $other)
                        <a href="{{ route('services.show', $other) }}" style="display: flex; gap: 10px; align-items: center; padding: 8px 0; text-decoration: none; color: var(--ink); font-weight: 600; font-size: 14.5px">
                            <span class="accent"><x-icon :name="$other->icon" size="18" stroke="2" /></span>{{ $other->title }}
                        </a>
                    @endforeach
                </div>
            @endif
        </aside>
    </div>
</section>

@if ($related->isNotEmpty())
<section class="section">
    <div class="container">
        <div class="section-head">
            <span class="eyebrow">Contoh Hasil Kerja</span>
            <h2 class="title-lg">Proyek terkait</h2>
        </div>
        <div class="grid grid-3">
            @foreach ($related as $portfolio)
                @include('partials.project-card')
            @endforeach
        </div>
    </div>
</section>
@endif

@include('partials.cta')
@endsection
