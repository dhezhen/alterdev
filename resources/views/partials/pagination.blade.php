@if ($paginator->hasPages())
    <nav aria-label="Navigasi halaman">
        <ul class="pagination">
            @if ($paginator->onFirstPage())
                <li><span class="disabled neu-sm" aria-hidden="true">‹</span></li>
            @else
                <li><a href="{{ $paginator->previousPageUrl() }}" class="neu-sm" rel="prev" aria-label="Sebelumnya">‹</a></li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li><span class="disabled">{{ $element }}</span></li>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li><span class="current" aria-current="page">{{ $page }}</span></li>
                        @else
                            <li><a href="{{ $url }}" class="neu-sm">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li><a href="{{ $paginator->nextPageUrl() }}" class="neu-sm" rel="next" aria-label="Berikutnya">›</a></li>
            @else
                <li><span class="disabled neu-sm" aria-hidden="true">›</span></li>
            @endif
        </ul>
    </nav>
@endif
