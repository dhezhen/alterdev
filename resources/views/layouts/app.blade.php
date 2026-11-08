@php
    $pageTitle = trim($__env->yieldContent('title'));
    $fullTitle = $pageTitle ? $pageTitle.' — '.$site['site_name'] : $site['site_name'].' — '.$site['site_tagline'];
    $metaDescription = trim($__env->yieldContent('description')) ?: $site['site_description'];
    $wa = preg_replace('/\D/', '', $site['contact_whatsapp'] ?? '');
    $nav = [
        ['home', 'Beranda'],
        ['services.index', 'Layanan'],
        ['trainings.index', 'Pelatihan'],
        ['portfolios.index', 'Portofolio'],
        ['blog.index', 'Blog'],
        ['about', 'Tentang Kami'],
    ];
@endphp
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $fullTitle }}</title>
    <meta name="description" content="{{ \Illuminate\Support\Str::limit($metaDescription, 160) }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ $site['site_name'] }}">
    <meta property="og:title" content="{{ $fullTitle }}">
    <meta property="og:description" content="{{ \Illuminate\Support\Str::limit($metaDescription, 160) }}">
    <meta property="og:url" content="{{ url()->current() }}">
    @hasSection('og_image')<meta property="og:image" content="@yield('og_image')">@endif
    <link rel="icon" href="{{ asset('images/alterdev-icon.png') }}" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/site.css') }}?v=5">
    @stack('head')
</head>
<body>
<div class="page">
    <div class="blob blob-1" aria-hidden="true"></div>
    <div class="blob blob-2" aria-hidden="true"></div>
    <div class="blob blob-3" aria-hidden="true"></div>

    <header class="site-header">
        <div class="container">
            <nav class="nav glass" aria-label="Navigasi utama">
                <a href="{{ route('home') }}" class="brand">
                    <img src="{{ asset('images/alterdev-logo-horizontal.png') }}" alt="{{ $site['site_name'] }}" class="brand-logo">
                </a>
                <button type="button" class="nav-toggle neu-sm" aria-label="Buka menu" aria-expanded="false" aria-controls="nav-links" data-nav-toggle>
                    <x-icon name="menu" size="22" stroke="2" />
                </button>
                <div class="nav-links" id="nav-links">
                    @foreach ($nav as [$route, $label])
                        <a href="{{ route($route) }}" @class(['active' => request()->routeIs($route === 'home' ? 'home' : \Illuminate\Support\Str::before($route, '.').'*')])>{{ $label }}</a>
                    @endforeach
                </div>
                <a href="{{ route('contact') }}" class="btn btn-primary btn-sm nav-cta">Konsultasi Gratis</a>
            </nav>
        </div>
    </header>

    <main id="konten">
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="container">
            <div class="footer-box neu">
                <div class="footer-col" style="flex: 1 1 260px; min-width: 0">
                    <img src="{{ asset('images/alterdev-logo-horizontal.png') }}" alt="{{ $site['site_name'] }}" class="footer-logo">
                    <span style="font-weight: 600; color: #3B4558">{{ $site['site_tagline'] }}</span>
                    <span class="small" style="max-width: 300px; line-height: 1.65">{{ $site['site_description'] }}</span>
                    <div class="socials">
                        @foreach (['instagram' => 'Instagram', 'linkedin' => 'LinkedIn', 'youtube' => 'YouTube'] as $key => $label)
                            @if (! empty($site['social_'.$key]))
                                <a href="{{ $site['social_'.$key] }}" class="neu-sm" target="_blank" rel="noopener" aria-label="{{ $label }}"><x-icon :name="$key" size="18" /></a>
                            @endif
                        @endforeach
                    </div>
                </div>
                <nav class="footer-col" aria-label="Layanan" style="flex: 0 1 190px">
                    <span class="head">Layanan</span>
                    @foreach (\App\Models\Service::active()->ordered()->get(['title', 'slug']) as $footerService)
                        <a href="{{ route('services.show', $footerService) }}">{{ $footerService->title }}</a>
                    @endforeach
                </nav>
                <nav class="footer-col" aria-label="Jelajahi" style="flex: 0 1 160px">
                    <span class="head">Jelajahi</span>
                    <a href="{{ route('portfolios.index') }}">Portofolio</a>
                    <a href="{{ route('trainings.index') }}">Jadwal Pelatihan</a>
                    <a href="{{ route('blog.index') }}">Blog</a>
                    <a href="{{ route('about') }}">Tentang Kami</a>
                    <a href="{{ route('contact') }}">Kontak</a>
                </nav>
                <div class="footer-col" style="flex: 0 1 240px; color: var(--muted-2)">
                    <span class="head">Kontak</span>
                    <span>{{ $site['contact_whatsapp'] }}</span>
                    @if (! empty($site['contact_whatsapp_secondary']))
                        <span>{{ $site['contact_whatsapp_secondary'] }}</span>
                    @endif
                    <span>{{ $site['contact_email'] }}</span>
                    <span>{{ $site['contact_address'] }}</span>
                    <span>{{ $site['contact_hours'] }}</span>
                </div>
            </div>
            <p class="copyright">© {{ date('Y') }} {{ $site['site_name'] }}. Hak cipta dilindungi.</p>
        </div>
    </footer>

    @if (strlen($wa) >= 9)
        <a href="https://wa.me/{{ $wa }}?text={{ rawurlencode('Assalamu\'alaikum, saya ingin konsultasi dengan '.$site['site_name'].'.') }}" class="wa-float" target="_blank" rel="noopener" aria-label="Chat WhatsApp">
            <x-icon name="whatsapp" size="26" stroke="1.8" />
        </a>
    @endif
</div>
<script src="{{ asset('js/site.js') }}?v=1" defer></script>
@stack('scripts')
</body>
</html>
