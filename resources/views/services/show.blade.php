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
                @if ($service->startingPricingPackage())
                    <p class="small"><strong class="accent">Mulai {{ $service->startingPricingPackage()['price_display'] ?: 'Rp'.number_format((int) $service->startingPricingPackage()['price'], 0, ',', '.') }}</strong></p>
                @elseif ($service->price_label)
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

@if (count($pricingPackages))
<section class="section pricing-section">
    <div class="container">
        <div class="section-head center pricing-section-head">
            <p class="pricing-intro-copy">Kami punya {{ count($pricingPackages) }} pilihan paket yang fleksibel dan sesuai dengan kebutuhan. Tinggal pilih yang paling pas buat bisnismu.</p>
        </div>
        <div class="grid grid-3 pricing-grid">
            @foreach ($pricingPackages as $package)
                <article class="box price-package price-package--{{ $package['accent_color'] ?? 'blue' }}">
                    <div class="package-heading">
                        <h3>{{ $package['name'] }}</h3>
                        @if (! empty($package['summary']))<p class="small">{{ $package['summary'] }}</p>@endif
                    </div>
                    <div class="package-pricing">
                        @if (! empty($package['price_kicker']))<p class="package-kicker">{{ $package['price_kicker'] }}</p>@endif
                        @if (! empty($package['compare_price']) || ! empty($package['compare_price_display']) || ! empty($package['discount_label']))
                            <p class="package-discount-line">
                                @if (! empty($package['compare_price_display']))
                                    <s>{{ $package['compare_price_display'] }}</s>
                                @elseif (! empty($package['compare_price']))
                                    <s>Rp{{ number_format((int) $package['compare_price'], 0, ',', '.') }},-</s>
                                @endif
                                @if (! empty($package['discount_label']))<strong>{{ $package['discount_label'] }}</strong>@endif
                            </p>
                        @endif
                        @if (is_numeric($package['price'] ?? null))
                            <p class="package-price">{{ $package['price_display'] ?: 'Rp'.number_format((int) $package['price'], 0, ',', '.') }}</p>
                        @else
                            <p class="package-price">Harga konsultasi</p>
                        @endif
                        @if (! empty($package['price_note']))<p class="package-price-note">{{ $package['price_note'] }}</p>@endif
                    </div>
                    @if (! empty($package['features']) || ! empty($package['excluded_features']))
                        <ul class="package-features">
                            @foreach ($package['features'] ?? [] as $feature)
                                <li class="is-included"><span aria-hidden="true">✓</span><span>{{ $feature }}</span></li>
                            @endforeach
                            @foreach ($package['excluded_features'] ?? [] as $feature)
                                <li class="is-excluded"><span aria-hidden="true">×</span><s>{{ $feature }}</s></li>
                            @endforeach
                        </ul>
                    @endif
                    @if (! empty($package['services']))
                        <div class="package-list">
                            <strong>Layanan termasuk</strong>
                            <ul>@foreach ($package['services'] as $item)<li>{{ $item }}</li>@endforeach</ul>
                        </div>
                    @endif
                    @if (! empty($package['renewal_label']))<p class="package-renewal">{{ $package['renewal_label'] }}</p>@endif
                    <a href="{{ route('contact', ['layanan' => $service->title]) }}" class="btn package-cta">Pilih Paket</a>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

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
