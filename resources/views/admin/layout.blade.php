@php
    $menu = [
        'Utama' => [
            ['admin.dashboard', 'Dasbor', 'dashboard', 'admin.dashboard', null],
            ['admin.messages.index', 'Pesan Masuk', 'inbox', 'admin.messages.*', $badges['messages'] ?? 0],
        ],
        'Pelatihan' => [
            ['admin.trainings.index', 'Program Pelatihan', 'cap', 'admin.trainings.*', null],
            ['admin.schedules.index', 'Jadwal', 'calendar', 'admin.schedules.*', null],
            ['admin.registrations.index', 'Pendaftar', 'user-plus', 'admin.registrations.*', $badges['registrations'] ?? 0],
        ],
        'Konten' => [
            ['admin.services.index', 'Layanan', 'grid', 'admin.services.*', null],
            ['admin.portfolios.index', 'Portofolio', 'briefcase', 'admin.portfolios.*', null],
            ['admin.testimonials.index', 'Testimoni', 'star', 'admin.testimonials.*', null],
            ['admin.faqs.index', 'FAQ', 'help', 'admin.faqs.*', null],
            ['admin.team.index', 'Tim', 'users', 'admin.team.*', null],
            ['admin.posts.index', 'Blog', 'pen', 'admin.posts.*', null],
        ],
        'Sistem' => [
            ['admin.settings.edit', 'Pengaturan Situs', 'settings', 'admin.settings.*', null],
            ['admin.users.index', 'Pengguna Admin', 'shield', 'admin.users.*', null],
        ],
    ];
@endphp
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Dasbor') — Admin {{ $site['site_name'] }}</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v=1">
</head>
<body>
<div class="admin">
    <aside class="sidebar" id="sidebar" aria-label="Menu admin">
        <a href="{{ route('admin.dashboard') }}" class="brand"><span class="mark"><x-icon name="code" size="18" stroke="2.2" /></span>{{ $site['site_name'] }}</a>
        @foreach ($menu as $group => $items)
            <span class="group">{{ $group }}</span>
            @foreach ($items as [$route, $label, $icon, $pattern, $count])
                <a href="{{ route($route) }}" @class(['item', 'active' => request()->routeIs($pattern)])>
                    <x-icon :name="$icon" size="18" stroke="2" />{{ $label }}
                    @if ($count)<span class="count">{{ $count }}</span>@endif
                </a>
            @endforeach
        @endforeach
        <span class="group">Situs</span>
        <a href="{{ route('home') }}" class="item" target="_blank" rel="noopener"><x-icon name="external" size="18" stroke="2" />Lihat Website</a>
    </aside>

    <div class="main">
        <header class="topbar">
            <button type="button" class="btn btn-light btn-icon menu-btn" aria-label="Buka menu" aria-controls="sidebar" aria-expanded="false" data-sidebar-toggle><x-icon name="menu" size="20" stroke="2" /></button>
            <span style="color: var(--muted)">{{ now()->translatedFormat('l, j F Y') }}</span>
            <div class="user">
                <a href="{{ route('admin.account.edit') }}" style="color: var(--ink); text-decoration: none">{{ auth()->user()->name }}</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="btn btn-light btn-sm"><x-icon name="logout" size="16" stroke="2" />Keluar</button>
                </form>
            </div>
        </header>

        <main class="content">
            @if (session('success'))
                <div class="alert alert-success" role="status">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-error" role="alert">{{ session('error') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-error" role="alert">Ada isian yang perlu diperbaiki. Periksa kembali formulir di bawah.</div>
            @endif

            @yield('content')
        </main>
    </div>
</div>
<script src="{{ asset('js/admin.js') }}?v=2" defer></script>
</body>
</html>
