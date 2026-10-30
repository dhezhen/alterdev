<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Masuk — Admin {{ $site['site_name'] }}</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v=1">
</head>
<body>
<main class="auth">
    <div class="auth-card">
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px">
            <span style="width: 44px; height: 44px; border-radius: 12px; background: var(--accent); color: #fff; display: flex; align-items: center; justify-content: center"><x-icon name="code" size="22" stroke="2.2" /></span>
            <div>
                <h1 style="font-size: 20px">Panel Admin</h1>
                <p style="color: var(--muted); font-size: 13px">{{ $site['site_name'] }}</p>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success" role="status">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('login.attempt') }}" class="form">
            @csrf
            <x-admin.input name="email" label="Email" type="email" required autofocus autocomplete="username" />
            <x-admin.input name="password" label="Password" type="password" required autocomplete="current-password" />
            <x-admin.checkbox name="remember" label="Ingat saya" />
            <button type="submit" class="btn btn-primary" style="width: 100%; min-height: 46px">Masuk</button>
        </form>
        <p style="margin-top: 20px; text-align: center; font-size: 13px"><a href="{{ route('home') }}">← Kembali ke website</a></p>
    </div>
</main>
</body>
</html>
