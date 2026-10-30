@extends('admin.layout')

@section('title', 'Pengaturan Situs')

@section('content')
<div class="page-head">
    <div><h1>Pengaturan Situs</h1><p>Identitas, teks beranda, halaman Tentang Kami, dan informasi kontak.</p></div>
</div>

<form method="POST" action="{{ route('admin.settings.update') }}" style="max-width: 900px">
    @csrf
    @method('PUT')
    @foreach ($groups as $group => $fields)
        <section class="panel form">
            <h2 style="margin: 0">{{ $group }}</h2>
            @foreach ($fields as $key => [$label, $type])
                @if ($type === 'textarea')
                    <x-admin.textarea :name="$key" :label="$label" :value="$values[$key] ?? ''" rows="{{ str_contains($key, 'body') ? 8 : 3 }}" />
                @else
                    <x-admin.input :name="$key" :label="$label" :value="$values[$key] ?? ''" :type="str_starts_with($key, 'social_') ? 'url' : 'text'" />
                @endif
            @endforeach
        </section>
    @endforeach
    <div class="form-actions" style="margin-top: 20px">
        <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
    </div>
</form>
@endsection
