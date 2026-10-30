@extends('admin.layout')

@section('title', 'Testimoni')

@section('content')
<div class="page-head">
    <div><h1>Testimoni</h1><p>Gunakan ulasan asli dari klien dan pastikan sudah mendapat izin untuk ditampilkan.</p></div>
    <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary"><x-icon name="plus" size="16" stroke="2.2" />Tambah Testimoni</a>
</div>

<div class="table-wrap">
    <table>
        <thead><tr><th>Urutan</th><th>Klien</th><th>Testimoni</th><th>Status</th><th style="width: 1%">Aksi</th></tr></thead>
        <tbody>
        @forelse ($testimonials as $testimonial)
            <tr>
                <td>{{ $testimonial->sort_order }}</td>
                <td><strong>{{ $testimonial->name }}</strong><span class="sub">{{ collect([$testimonial->position, $testimonial->organization])->filter()->implode(', ') }}</span></td>
                <td>{{ \Illuminate\Support\Str::limit($testimonial->content, 120) }}<span class="sub">{{ str_repeat('★', $testimonial->rating) }}</span></td>
                <td><span class="badge {{ $testimonial->is_active ? 'b-on' : 'b-off' }}">{{ $testimonial->is_active ? 'Tampil' : 'Disembunyikan' }}</span></td>
                <td>
                    <div class="actions">
                        <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="btn btn-light btn-sm"><x-icon name="edit" size="15" stroke="2" />Ubah</a>
                        <x-admin.delete :action="route('admin.testimonials.destroy', $testimonial)" />
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="empty">Belum ada testimoni.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
