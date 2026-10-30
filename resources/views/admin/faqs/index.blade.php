@extends('admin.layout')

@section('title', 'FAQ')

@section('content')
<div class="page-head">
    <div><h1>FAQ</h1><p>Pertanyaan yang sering diajukan di beranda.</p></div>
    <a href="{{ route('admin.faqs.create') }}" class="btn btn-primary"><x-icon name="plus" size="16" stroke="2.2" />Tambah FAQ</a>
</div>

<div class="table-wrap">
    <table>
        <thead><tr><th>Urutan</th><th>Pertanyaan &amp; jawaban</th><th>Status</th><th style="width: 1%">Aksi</th></tr></thead>
        <tbody>
        @forelse ($faqs as $faq)
            <tr>
                <td>{{ $faq->sort_order }}</td>
                <td><strong>{{ $faq->question }}</strong><span class="sub">{{ \Illuminate\Support\Str::limit($faq->answer, 140) }}</span></td>
                <td><span class="badge {{ $faq->is_active ? 'b-on' : 'b-off' }}">{{ $faq->is_active ? 'Tampil' : 'Disembunyikan' }}</span></td>
                <td>
                    <div class="actions">
                        <a href="{{ route('admin.faqs.edit', $faq) }}" class="btn btn-light btn-sm"><x-icon name="edit" size="15" stroke="2" />Ubah</a>
                        <x-admin.delete :action="route('admin.faqs.destroy', $faq)" />
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="4" class="empty">Belum ada FAQ.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
