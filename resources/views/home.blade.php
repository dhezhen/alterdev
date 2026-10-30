@extends('layouts.app')

@section('content')
@php
    $heroTitle = e($site['hero_title']);
    if (! empty($site['hero_highlight'])) {
        $heroTitle = str_replace(e($site['hero_highlight']), '<span class="accent">'.e($site['hero_highlight']).'</span>', $heroTitle);
    }
@endphp

{{-- HERO --}}
<section class="hero" id="beranda">
    <div class="container row">
        <div class="stack" style="gap: 26px; flex-basis: 500px">
            <span class="badge neu-sm"><span class="dot"></span>{{ $site['site_tagline'] }}</span>
            <h1 class="title-xl">{!! $heroTitle !!}</h1>
            <p class="lead" style="max-width: 560px">{{ $site['hero_subtitle'] }}</p>
            <div style="display: flex; flex-wrap: wrap; gap: 16px; padding-top: 4px">
                <a href="{{ route('contact') }}" class="btn btn-primary">Ceritakan Kebutuhan Anda</a>
                <a href="{{ route('portfolios.index') }}" class="btn btn-soft">Lihat Hasil Kerja Kami</a>
            </div>
            <ul class="checks">
                <li><x-icon name="check" size="18" stroke="2.4" />Konsultasi awal gratis</li>
                <li><x-icon name="check" size="18" stroke="2.4" />Progres bisa dipantau</li>
                <li><x-icon name="check" size="18" stroke="2.4" />Pendampingan setelah rilis</li>
            </ul>
        </div>
        <div>
            <div class="hero-card glass">
                <div style="display: flex; align-items: center; justify-content: space-between">
                    <strong style="font-size: 16px">Apa yang bisa kami bantu?</strong>
                    <span class="window-dots" aria-hidden="true"><span></span><span></span><span></span></span>
                </div>
                <div class="tile-grid">
                    @foreach ($services->take(4) as $service)
                        <a href="{{ route('services.show', $service) }}" class="tile neu-sm">
                            <x-icon :name="$service->icon" size="26" stroke="1.8" />
                            <strong style="font-size: 15px">{{ $service->title }}</strong>
                        </a>
                    @endforeach
                </div>
                <div class="neu-in" style="border-radius: 18px; padding: 16px 18px; display: flex; align-items: center; gap: 14px">
                    <span style="width: 38px; height: 38px; flex: none; border-radius: 12px; background: var(--accent); color: #fff; display: flex; align-items: center; justify-content: center"><x-icon name="shield" size="18" stroke="2.2" /></span>
                    <span style="font-size: 14px; line-height: 1.5; color: #3B4558">Melayani UMKM, yayasan, pondok pesantren, sekolah, kampus, hingga pemerintah desa.</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- LAYANAN --}}
<section class="section" id="layanan">
    <div class="container">
        <div class="section-head center">
            <span class="eyebrow">Layanan Kami</span>
            <h2 class="title-lg">Sederhana, tepat guna, dan mudah digunakan</h2>
            <p class="lead" style="font-size: 17px">Kami fokus pada layanan yang paling sering dibutuhkan usaha dan lembaga. Tidak berlebihan, tidak rumit — cukup yang benar-benar Anda perlukan.</p>
        </div>
        <div class="grid grid-4">
            @foreach ($services as $service)
                <a href="{{ route('services.show', $service) }}" class="card neu">
                    <span class="icon-box neu-in"><x-icon :name="$service->icon" size="26" stroke="1.8" /></span>
                    <h3>{{ $service->title }}</h3>
                    <p class="small" style="line-height: 1.65; color: var(--muted); font-size: 14.5px">{{ $service->short_description }}</p>
                    @if ($service->features)
                        <ul>@foreach ($service->features as $feature)<li>{{ $feature }}</li>@endforeach</ul>
                    @endif
                    <span class="link-arrow accent" style="margin-top: auto; font-size: 14px">Selengkapnya →</span>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- PELATIHAN --}}
@if ($trainings->isNotEmpty())
<section class="section" id="pelatihan">
    <div class="container">
        <div class="box glass stack" style="gap: 40px">
            <div style="display: flex; flex-wrap: wrap; gap: 32px; align-items: flex-end; justify-content: space-between">
                <div class="stack" style="flex: 1 1 520px; min-width: 0">
                    <span class="eyebrow">Program Pelatihan IT</span>
                    <h2 class="title-lg">Belajar teknologi tanpa takut, langsung bisa dipraktikkan</h2>
                    <p class="lead" style="font-size: 17px">Cocok untuk guru, staf administrasi, pelaku UMKM, mahasiswa, hingga aparatur desa. Pelatihan bisa diadakan di lokasi Anda, secara daring, atau di tempat yang disepakati.</p>
                </div>
                <a href="{{ route('trainings.index') }}" class="btn btn-primary">Lihat Jadwal Pelatihan</a>
            </div>
            <div class="grid grid-4" style="gap: 20px">
                @foreach ($trainings as $training)
                    <a href="{{ route('trainings.show', $training) }}" class="mini-card neu-sm">
                        <span class="icon-box sm neu-in"><x-icon :name="$training->icon" size="21" stroke="2" /></span>
                        <span><strong>{{ $training->title }}</strong><span class="desc">{{ $training->summary }}</span></span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

{{-- PENDIDIKAN --}}
<section class="section" id="pendidikan">
    <div class="container">
        <div class="box glass stack" style="gap: 44px">
            <div style="display: flex; flex-wrap: wrap; gap: 40px; align-items: flex-end; justify-content: space-between">
                <div class="stack" style="flex: 1 1 520px; min-width: 0">
                    <span class="eyebrow">Pendampingan Lembaga Pendidikan</span>
                    <h2 class="title-lg">Mendampingi yayasan, pesantren, dan sekolah melangkah ke era digital</h2>
                    <p class="lead" style="font-size: 17px">Kami memahami setiap lembaga punya ritme dan kebutuhan yang khas — dari penerimaan santri baru, pencatatan hafalan, hingga laporan keuangan untuk pengurus yayasan. Kami dampingi langkah demi langkah, menyesuaikan kesiapan dan anggaran lembaga Anda.</p>
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 10px">
                    <span class="pill neu-sm">Yayasan</span>
                    <span class="pill neu-sm">Pondok Pesantren</span>
                    <span class="pill neu-sm">Sekolah &amp; Madrasah</span>
                </div>
            </div>
            <div class="grid grid-4" style="gap: 20px">
                @foreach ([
                    ['user-plus', 'PPDB & Penerimaan Santri Online', 'Pendaftaran, seleksi, hingga pengumuman tanpa antre.'],
                    ['file', 'Akademik & Rapor Digital', 'Jadwal, nilai, dan rapor tersusun otomatis.'],
                    ['card', 'Keuangan SPP, Syahriah & Donasi', 'Tagihan, pembayaran, dan laporan untuk pengurus yayasan.'],
                    ['book', 'Monitoring Tahfidz & Hafalan', 'Setoran hafalan tercatat dan bisa dipantau wali santri.'],
                    ['calendar-check', 'Presensi & Perizinan Santri', 'Kehadiran, izin pulang, dan kunjungan terdata rapi.'],
                    ['home', 'Website Profil Lembaga', 'Wajah resmi lembaga untuk calon wali, donatur, dan mitra.'],
                ] as [$icon, $title, $desc])
                    <div class="mini-card neu-sm">
                        <span class="icon-box sm neu-in"><x-icon :name="$icon" size="21" stroke="2" /></span>
                        <span><strong>{{ $title }}</strong><span class="desc">{{ $desc }}</span></span>
                    </div>
                @endforeach
            </div>
            <div class="neu-in" style="border-radius: 22px; padding: 24px 26px; display: flex; flex-wrap: wrap; gap: 20px 32px; align-items: center; justify-content: space-between">
                <ul class="checks" style="font-weight: 600; font-size: 14.5px">
                    <li><x-icon name="check" size="18" stroke="2.4" />Analisis kebutuhan lembaga</li>
                    <li><x-icon name="check" size="18" stroke="2.4" />Pelatihan guru, ustadz &amp; staf</li>
                    <li><x-icon name="check" size="18" stroke="2.4" />Pendampingan sampai sistem berjalan</li>
                    <li><x-icon name="check" size="18" stroke="2.4" />Bisa dibangun bertahap</li>
                </ul>
                <a href="{{ route('contact', ['layanan' => 'Pendampingan Yayasan / Pesantren / Sekolah']) }}" class="btn btn-primary btn-sm">Konsultasikan Lembaga Anda</a>
            </div>
        </div>
    </div>
</section>

{{-- PORTOFOLIO --}}
@if ($portfolios->isNotEmpty() || $activeCategory)
<section class="section" id="portofolio">
    <div class="container">
        <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: flex-end; gap: 24px; margin-bottom: 40px">
            <div class="stack" style="max-width: 620px; gap: 14px">
                <span class="eyebrow">Portofolio</span>
                <h2 class="title-lg">Proyek yang telah kami kerjakan</h2>
                <p class="lead" style="font-size: 17px">Setiap proyek berangkat dari masalah nyata di lapangan. Berikut beberapa di antaranya.</p>
            </div>
            <nav class="filter neu-in" aria-label="Saring proyek berdasarkan kategori">
                <a href="{{ route('home') }}#portofolio" @class(['active' => ! $activeCategory])>Semua</a>
                @foreach ($categories as $cat)
                    <a href="{{ route('home', ['kategori' => $cat]) }}#portofolio" @class(['active' => $activeCategory === $cat])>{{ $cat }}</a>
                @endforeach
            </nav>
        </div>
        <div class="grid grid-3">
            @foreach ($portfolios as $portfolio)
                @include('partials.project-card')
            @endforeach
            <a href="{{ route('contact') }}" class="add-card">
                <span class="neu" style="width: 64px; height: 64px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--accent)"><x-icon name="plus" size="28" stroke="2.2" /></span>
                <strong style="font-size: 19px">Proyek Anda berikutnya?</strong>
                <span class="small" style="max-width: 260px; color: var(--muted)">Ceritakan idenya. Kami bantu menimbang solusi yang paling masuk akal untuk Anda.</span>
                <span class="accent" style="font-weight: 700">Mulai diskusi →</span>
            </a>
        </div>
        <p style="text-align: center; margin-top: 36px"><a href="{{ route('portfolios.index') }}" class="btn btn-soft">Lihat Semua Portofolio</a></p>
    </div>
</section>
@endif

{{-- CARA KERJA --}}
<section class="section" id="proses">
    <div class="container">
        <div class="box glass">
            <div class="section-head center">
                <span class="eyebrow">Cara Kerja</span>
                <h2 class="title-lg">Jelas dari awal, tanpa kejutan di akhir</h2>
                <p class="lead" style="font-size: 17px">Anda selalu tahu proyek sedang di tahap mana dan apa langkah berikutnya.</p>
            </div>
            <ol class="steps">
                @foreach ([
                    ['Dengarkan', 'Kita ngobrol santai soal kebutuhan, tujuan, dan kendala yang sedang Anda hadapi.'],
                    ['Rancang', 'Kami susun alur sistem, desain tampilan, jadwal, dan biaya — semuanya tertulis.'],
                    ['Bangun', 'Pengembangan bertahap. Anda bisa mencoba hasilnya dan memberi masukan di setiap tahap.'],
                    ['Dampingi', 'Peluncuran, pelatihan pengguna, dan dukungan teknis agar sistem terus berjalan lancar.'],
                ] as $i => [$title, $desc])
                    <li class="neu-sm">
                        <span class="step-num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        <strong>{{ $title }}</strong>
                        <span class="small" style="line-height: 1.65; color: var(--muted)">{{ $desc }}</span>
                    </li>
                @endforeach
            </ol>
        </div>
    </div>
</section>

{{-- KEUNGGULAN --}}
<section class="section" id="keunggulan">
    <div class="container row" style="align-items: flex-start">
        <div class="stack" style="flex-basis: 360px">
            <span class="eyebrow">Mengapa {{ $site['site_name'] }}</span>
            <h2 class="title-lg">Bukan sekadar vendor, tapi rekan kerja</h2>
            <p class="lead" style="font-size: 17px">Kami percaya teknologi yang baik adalah teknologi yang benar-benar dipakai. Karena itu kami tidak berhenti di serah terima — kami ingin memastikan sistemnya membantu pekerjaan Anda setiap hari.</p>
        </div>
        <div class="grid" style="flex: 1.4 1 520px; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 22px">
            @foreach ([
                ['cap', 'Praktisi & Akademisi', 'Tim kami berpengalaman di rekayasa perangkat lunak dan pendidikan teknologi.'],
                ['tool', 'Dibuat Sesuai Kebutuhan', 'Sistem mengikuti cara kerja Anda, bukan Anda yang dipaksa menyesuaikan sistem.'],
                ['shield', 'Aman & Terdokumentasi', 'Data Anda dijaga dengan baik, dan setiap sistem dilengkapi dokumentasi yang rapi.'],
                ['headset', 'Tetap Didampingi', 'Ada kendala setelah sistem berjalan? Kami tetap bisa dihubungi dan siap membantu.'],
            ] as [$icon, $title, $desc])
                <div class="mini-card neu" style="padding: 26px">
                    <span class="icon-box sm neu-in"><x-icon :name="$icon" size="22" stroke="2" /></span>
                    <span><strong style="font-size: 16px">{{ $title }}</strong><span class="desc" style="font-size: 14px">{{ $desc }}</span></span>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- TESTIMONI --}}
@if ($testimonials->isNotEmpty())
<section class="section" id="testimoni">
    <div class="container">
        <div class="section-head center">
            <span class="eyebrow">Testimoni</span>
            <h2 class="title-lg">Apa kata mereka yang sudah bekerja sama</h2>
        </div>
        <div class="grid grid-2" style="grid-template-columns: repeat(auto-fit, minmax(min(300px, 100%), 1fr))">
            @foreach ($testimonials as $testimonial)
                @include('partials.testimonial')
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- BLOG --}}
@if ($posts->isNotEmpty())
<section class="section" id="artikel">
    <div class="container">
        <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: flex-end; gap: 24px; margin-bottom: 40px">
            <div class="stack" style="max-width: 620px; gap: 14px">
                <span class="eyebrow">Artikel</span>
                <h2 class="title-lg">Tips &amp; wawasan teknologi</h2>
            </div>
            <a href="{{ route('blog.index') }}" class="btn btn-soft btn-sm">Semua Artikel</a>
        </div>
        <div class="grid grid-3">
            @foreach ($posts as $post)
                @include('partials.post-card')
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- FAQ --}}
@if ($faqs->isNotEmpty())
<section class="section" id="faq">
    <div class="container" style="max-width: 900px">
        <div class="section-head center">
            <span class="eyebrow">Pertanyaan Umum</span>
            <h2 class="title-lg">Yang sering ditanyakan</h2>
        </div>
        <div class="stack">
            @foreach ($faqs as $faq)
                <details class="faq neu-sm" @if ($loop->first) open @endif>
                    <summary>{{ $faq->question }}<span class="sign neu-in" aria-hidden="true"></span></summary>
                    <p>{{ $faq->answer }}</p>
                </details>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- KONTAK --}}
<section class="section" id="kontak">
    <div class="container">
        <div class="box glass row" style="align-items: flex-start">
            <div class="stack" style="flex-basis: 340px">
                <span class="eyebrow">Hubungi Kami</span>
                <h2 class="title-lg">Punya ide atau kendala? Yuk, kita bicarakan.</h2>
                <p class="lead" style="font-size: 17px">Tidak perlu menyiapkan dokumen teknis. Ceritakan saja apa yang ingin Anda capai — kami yang bantu menerjemahkannya menjadi solusi. Konsultasi awal gratis.</p>
                @include('partials.contact-info')
            </div>
            <div style="flex: 1.2 1 400px">
                @include('partials.contact-form')
            </div>
        </div>
    </div>
</section>
@endsection
