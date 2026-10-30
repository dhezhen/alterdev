{{-- Kartu portofolio. Variabel: $portfolio, $loop (opsional) --}}
<a href="{{ route('portfolios.show', $portfolio) }}" class="card project neu">
    <div class="project-thumb glass {{ $portfolio->image ? '' : 'tint-'.($portfolio->id % 5) }}">
        @if ($portfolio->image)
            <img src="{{ $portfolio->imageUrl() }}" alt="Tampilan {{ $portfolio->title }}" loading="lazy">
        @else
            <div class="mock" role="img" aria-label="Ilustrasi {{ $portfolio->title }}">
                <div class="window-dots" aria-hidden="true"><span></span><span></span><span></span></div>
                <div class="mock-body" aria-hidden="true">
                    <div class="mock-side"><span></span><span></span><span></span><span></span></div>
                    <div class="mock-main">
                        <div class="mock-title">{{ \Illuminate\Support\Str::limit($portfolio->title, 28) }}</div>
                        <div class="mock-cells"><span></span><span></span><span></span></div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div class="project-body">
        <span class="chip neu-in" style="align-self: flex-start">{{ $portfolio->category }}</span>
        <h3>{{ $portfolio->title }}</h3>
        <p class="small" style="line-height: 1.65; color: var(--muted)">{{ $portfolio->summary }}</p>
        @if ($portfolio->tags)
            <div class="tags" style="padding-top: 4px">
                @foreach ($portfolio->tags as $tag)
                    <span class="tag">{{ $tag }}</span>
                @endforeach
            </div>
        @endif
    </div>
</a>
