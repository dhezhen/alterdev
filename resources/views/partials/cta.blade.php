{{-- Ajakan konsultasi di bagian bawah halaman --}}
<section class="section">
    <div class="container">
        <div class="box glass" style="display: flex; flex-wrap: wrap; gap: 28px; align-items: center; justify-content: space-between">
            <div class="stack" style="flex: 1 1 480px; min-width: 0">
                <h2 class="title-lg">{{ $title ?? 'Punya ide atau kendala? Yuk, kita bicarakan.' }}</h2>
                <p class="lead">{{ $text ?? 'Tidak perlu menyiapkan dokumen teknis. Ceritakan saja apa yang ingin Anda capai — konsultasi awal gratis.' }}</p>
            </div>
            <div style="display: flex; flex-wrap: wrap; gap: 14px">
                <a href="{{ route('contact') }}" class="btn btn-primary">Hubungi Kami</a>
                <a href="{{ route('portfolios.index') }}" class="btn btn-soft">Lihat Portofolio</a>
            </div>
        </div>
    </div>
</section>
