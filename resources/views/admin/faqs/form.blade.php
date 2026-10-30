@extends('admin.layout')

@section('title', $faq->exists ? 'Ubah FAQ' : 'Tambah FAQ')

@section('content')
<div class="page-head">
    <div><h1>{{ $faq->exists ? 'Ubah FAQ' : 'Tambah FAQ' }}</h1></div>
    <a href="{{ route('admin.faqs.index') }}" class="btn btn-light"><x-icon name="arrow-left" size="16" stroke="2" />Kembali</a>
</div>

<form method="POST" action="{{ $faq->exists ? route('admin.faqs.update', $faq) : route('admin.faqs.store') }}" class="panel form" style="max-width: 820px">
    @csrf
    @if ($faq->exists) @method('PUT') @endif
    <x-admin.input name="question" label="Pertanyaan" :value="$faq->question" required />
    <x-admin.textarea name="answer" label="Jawaban" :value="$faq->answer" rows="6" required />
    <div class="form-row">
        <x-admin.input name="sort_order" label="Urutan tampil" type="number" min="0" :value="$faq->sort_order ?? 0" />
    </div>
    <x-admin.checkbox name="is_active" label="Tampilkan di website" :checked="$faq->is_active" />
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.faqs.index') }}" class="btn btn-light">Batal</a>
    </div>
</form>
@endsection
