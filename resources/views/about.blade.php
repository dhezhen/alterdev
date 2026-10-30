@extends('layouts.app')

@section('title', 'Tentang Kami')
@section('description', $site['about_vision'])

@section('content')
@include('partials.page-hero', [
    'eyebrow' => 'Tentang Kami',
    'title' => $site['about_title'],
    'crumbs' => ['Tentang Kami' => null],
])

<section class="section" style="padding-top: 0">
    <div class="container layout-side">
        <article class="main box glass prose" style="padding: 44px">
            {!! \Illuminate\Support\Str::markdown($site['about_body'] ?? '', ['html_input' => 'strip', 'allow_unsafe_links' => false]) !!}
        </article>
        <aside class="side">
            <div class="neu" style="border-radius: 26px; padding: 28px" >
                <span class="eyebrow">Visi</span>
                <p style="margin-top: 10px; font-size: 16px; line-height: 1.7; font-weight: 600">{{ $site['about_vision'] }}</p>
            </div>
            <div class="neu" style="border-radius: 26px; padding: 28px">
                <span class="eyebrow">Misi</span>
                <ul class="checks" style="flex-direction: column; gap: 12px; margin-top: 14px; font-size: 15px">
                    @foreach (preg_split('/\r\n|\r|\n/', trim($site['about_mission'] ?? '')) as $mission)
                        @if (trim($mission) !== '')
                            <li style="align-items: flex-start"><x-icon name="check" size="18" stroke="2.4" style="margin-top: 3px" />{{ trim($mission) }}</li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <div class="neu-in" style="border-radius: 22px; padding: 22px; display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 12px; text-align: center">
                @foreach ($stats as $label => $value)
                    <div><strong class="accent" style="font-size: 26px; display: block">{{ $value }}</strong><span class="small" style="font-size: 12.5px">{{ $label }}</span></div>
                @endforeach
            </div>
        </aside>
    </div>
</section>

@if ($team->isNotEmpty())
<section class="section">
    <div class="container">
        <div class="section-head center">
            <span class="eyebrow">Tim Kami</span>
            <h2 class="title-lg">Orang-orang di balik {{ $site['site_name'] }}</h2>
        </div>
        <div class="grid grid-3">
            @foreach ($team as $member)
                <div class="card neu" style="align-items: center; text-align: center; padding: 34px 26px">
                    <span class="avatar neu-in" style="width: 104px; height: 104px; font-size: 30px">
                        @if ($member->photo)
                            <img src="{{ $member->photoUrl() }}" alt="Foto {{ $member->name }}">
                        @else
                            {{ $member->initials() }}
                        @endif
                    </span>
                    <div>
                        <h3>{{ $member->name }}</h3>
                        <p class="accent" style="font-weight: 600; font-size: 14px; margin-top: 4px">{{ $member->position }}</p>
                    </div>
                    @if ($member->bio)<p class="small" style="line-height: 1.65; color: var(--muted)">{{ $member->bio }}</p>@endif
                    @if ($member->linkedin)
                        <a href="{{ $member->linkedin }}" target="_blank" rel="noopener" class="neu-sm" style="width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center" aria-label="LinkedIn {{ $member->name }}"><x-icon name="linkedin" size="18" /></a>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@include('partials.cta')
@endsection
