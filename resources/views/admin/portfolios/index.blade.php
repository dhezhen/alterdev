@extends('admin.layout')

@section('title', 'Portofolio')

@section('content')
<div class="page-head">
    <div><h1>Portofolio</h1><p>Proyek yang ditampilkan di website.</p></div>
    <a href="{{ route('admin.portfolios.create') }}" class="btn btn-primary"><x-icon name="plus" size="16" stroke="2.2" />Tambah Proyek</a>
</div>

<form method="GET" class="filters">
    <div class="tabs">
        <a href="{{ route('admin.portfolios.index', array_filter(['q' => request('q')])) }}" @class(['active' => ! request('kategori')])>Semua</a>
        @foreach (\App\Models\Portfolio::CATEGORIES as $cat)
            <a href="{{ route('admin.portfolios.index', array_filter(['kategori' => $cat, 'q' => request('q')])) }}" @class(['active' => request('kategori') === $cat])>{{ $cat }}</a>
        @endforeach
    </div>
    @if (request('kategori'))<input type="hidden" name="kategori" value="{{ request('kategori') }}">@endif
    <input type="search" name="q" value="{{ request('q') }}" class="input" placeholder="Cari judul…" style="max-width: 260px" aria-label="Cari judul">
    <button class="btn btn-light">Cari</button>
</form>

<div class="table-wrap">
    <table>
        <thead><tr><th>Gambar</th><th>Proyek</th><th>Kategori</th><th>Status</th><th style="width: 1%">Aksi</th></tr></thead>
        <tbody>
        @forelse ($portfolios as $portfolio)
            <tr>
                <td>@if ($portfolio->image)<img src="{{ $portfolio->imageUrl() }}" alt="" class="thumb-sm">@else<span class="sub">—</span>@endif</td>
                <td>
                    <strong>{{ $portfolio->title }}</strong> @if ($portfolio->is_featured)<span class="badge b-confirmed">Unggulan</span>@endif
                    <span class="sub">{{ collect([$portfolio->client, $portfolio->year])->filter()->implode(' · ') ?: \Illuminate\Support\Str::limit($portfolio->summary, 90) }}</span>
                </td>
                <td>{{ $portfolio->category }}</td>
                <td><span class="badge {{ $portfolio->is_active ? 'b-on' : 'b-off' }}">{{ $portfolio->is_active ? 'Tampil' : 'Disembunyikan' }}</span></td>
                <td>
                    <div class="actions">
                        <a href="{{ route('admin.portfolios.edit', $portfolio) }}" class="btn btn-light btn-sm"><x-icon name="edit" size="15" stroke="2" />Ubah</a>
                        <x-admin.delete :action="route('admin.portfolios.destroy', $portfolio)" />
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="empty">Belum ada proyek.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
{{ $portfolios->links() }}
@endsection
