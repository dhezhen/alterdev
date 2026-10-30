{{-- Kartu artikel. Variabel: $post --}}
<a href="{{ route('blog.show', $post) }}" class="card project neu">
    <div class="project-thumb glass {{ $post->cover_image ? '' : 'tint-'.($post->id % 5) }}" style="height: 180px">
        @if ($post->cover_image)
            <img src="{{ $post->coverUrl() }}" alt="" loading="lazy">
        @else
            <div style="height: 100%; display: flex; align-items: center; justify-content: center; color: var(--accent)" aria-hidden="true"><x-icon name="pen" size="44" stroke="1.4" /></div>
        @endif
    </div>
    <div class="project-body">
        <div class="meta">
            @if ($post->category)<span class="chip neu-in">{{ $post->category }}</span>@endif
            <span style="align-self: center">{{ $post->published_at?->translatedFormat('j F Y') }}</span>
        </div>
        <h3>{{ $post->title }}</h3>
        <p class="small" style="line-height: 1.65; color: var(--muted)">{{ $post->excerptText() }}</p>
    </div>
</a>
