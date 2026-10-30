{{-- Kartu testimoni. Variabel: $testimonial --}}
<figure class="quote glass">
    <span class="stars" role="img" aria-label="{{ $testimonial->rating }} dari 5 bintang">
        @for ($i = 0; $i < $testimonial->rating; $i++)
            <x-icon name="star" size="18" stroke="0" />
        @endfor
    </span>
    <blockquote>“{{ $testimonial->content }}”</blockquote>
    <figcaption>
        <span class="avatar neu-sm">
            @if ($testimonial->photo)
                <img src="{{ $testimonial->photoUrl() }}" alt="">
            @else
                {{ $testimonial->initials() }}
            @endif
        </span>
        <span style="display: flex; flex-direction: column; gap: 2px">
            <strong style="font-size: 15px">{{ $testimonial->name }}</strong>
            <span class="small" style="font-size: 13px">{{ collect([$testimonial->position, $testimonial->organization])->filter()->implode(', ') }}</span>
        </span>
    </figcaption>
</figure>
