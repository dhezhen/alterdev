@extends('layouts.app')

@section('title', 'Layanan')
@section('description', 'Layanan pembuatan website company profile, sistem informasi, aplikasi, dan pelatihan IT.')

@section('content')
@include('partials.page-hero', [
    'eyebrow' => 'Layanan Kami',
    'title' => 'Solusi digital yang sederhana dan tepat guna',
    'text' => 'Pilih layanan sesuai kebutuhan Anda sekarang. Kami siap menemani ketika kebutuhan Anda bertambah.',
    'crumbs' => ['Layanan' => null],
])

<section class="section" style="padding-top: 0">
    <div class="container stack" style="gap: 32px">
        @foreach ($services as $service)
            <article class="box neu row" style="padding: 40px; border-radius: 30px; align-items: flex-start">
                <div class="stack" style="flex-basis: 460px">
                    <span class="icon-box neu-in" style="width: 64px; height: 64px"><x-icon :name="$service->icon" size="30" stroke="1.8" /></span>
                    <h2 class="title-md">{{ $service->title }}</h2>
                    <p class="text">{{ $service->short_description }}</p>
                    @if ($service->startingPricingPackage())
                        <p class="small"><strong class="accent">Mulai {{ $service->startingPricingPackage()['price_display'] ?: 'Rp'.number_format((int) $service->startingPricingPackage()['price'], 0, ',', '.') }}</strong></p>
                    @elseif ($service->price_label)
                        <p class="small"><strong class="accent">{{ $service->price_label }}</strong></p>
                    @endif
                    <div style="display: flex; flex-wrap: wrap; gap: 12px; padding-top: 6px">
                        <a href="{{ route('services.show', $service) }}" class="btn btn-primary btn-sm">Lihat Detail</a>
                        <a href="{{ route('contact', ['layanan' => $service->title]) }}" class="btn btn-soft btn-sm">Konsultasi</a>
                    </div>
                </div>
                @if ($service->features)
                    <ul class="neu-in" style="list-style: none; margin: 0; padding: 26px 28px; border-radius: 22px; display: flex; flex-direction: column; gap: 14px; font-size: 15px">
                        @foreach ($service->features as $feature)
                            <li style="display: flex; gap: 10px; align-items: flex-start"><span class="accent" style="margin-top: 2px"><x-icon name="check" size="18" stroke="2.4" /></span>{{ $feature }}</li>
                        @endforeach
                    </ul>
                @endif
            </article>
        @endforeach
    </div>
</section>

@include('partials.cta')
@endsection
