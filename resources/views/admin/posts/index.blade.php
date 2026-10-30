@extends('admin.layout')

@section('title', 'Blog')

@section('content')
<div class="page-head">
    <div><h1>Blog</h1><p>Artikel untuk berbagi wawasan dan meningkatkan visibilitas di mesin pencari.</p></div>
    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary"><x-icon name="plus" size="16" stroke="2.2" />Tulis Artikel</a>
</div>

<form method="GET" class="filters">
    <div class="tabs">
        <a href="{{ route('admin.posts.index', array_filter(['q' => $search])) }}" @class(['active' => ! request('status')])>Semua</a>
        <a href="{{ route('admin.posts.index', array_filter(['status' => 'terbit', 'q' => $search])) }}" @class(['active' => request('status') === 'terbit'])>Terbit</a>
        <a href="{{ route('admin.posts.index', array_filter(['status' => 'draf', 'q' => $search])) }}" @class(['active' => request('status') === 'draf'])>Draf</a>
    </div>
    @if (request('status'))<input type="hidden" name="status" value="{{ request('status') }}">@endif
    <input type="search" name="q" value="{{ $search }}" class="input" placeholder="Cari judul…" style="max-width: 260px" aria-label="Cari judul artikel">
    <button class="btn btn-light">Cari</button>
</form>

<div class="table-wrap">
    <table>
        <thead><tr><th>Artikel</th><th>Kategori</th><th>Status</th><th>Dibaca</th><th style="width: 1%">Aksi</th></tr></thead>
        <tbody>
        @forelse ($posts as $post)
            <tr>
                <td><strong>{{ $post->title }}</strong><span class="sub">{{ $post->author?->name }} · diperbarui {{ $post->updated_at->diffForHumans() }}</span></td>
                <td>{{ $post->category ?: '—' }}</td>
                <td>
                    @if ($post->is_published && $post->published_at?->isFuture())
                        <span class="badge b-confirmed">Terjadwal</span><span class="sub">{{ $post->published_at->format('d/m/Y H:i') }}</span>
                    @elseif ($post->is_published)
                        <span class="badge b-on">Terbit</span><span class="sub">{{ $post->published_at?->format('d/m/Y') }}</span>
                    @else
                        <span class="badge b-off">Draf</span>
                    @endif
                </td>
                <td>{{ number_format($post->views, 0, ',', '.') }}</td>
                <td>
                    <div class="actions">
                        @if ($post->is_published)<a href="{{ route('blog.show', $post) }}" target="_blank" class="btn btn-light btn-sm" title="Lihat"><x-icon name="eye" size="15" stroke="2" /></a>@endif
                        <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-light btn-sm"><x-icon name="edit" size="15" stroke="2" />Ubah</a>
                        <x-admin.delete :action="route('admin.posts.destroy', $post)" />
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="empty">Belum ada artikel.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
{{ $posts->links() }}
@endsection
