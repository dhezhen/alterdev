@extends('admin.layout')

@section('title', 'Pesan dari '.$message->name)

@section('content')
<div class="page-head">
    <div><h1>{{ $message->name }}</h1><p>Dikirim {{ $message->created_at->translatedFormat('l, j F Y H:i') }} ({{ $message->created_at->diffForHumans() }})</p></div>
    <a href="{{ route('admin.messages.index') }}" class="btn btn-light"><x-icon name="arrow-left" size="16" stroke="2" />Kembali</a>
</div>

<div class="split">
    <div class="main-col">
        <section class="panel">
            <h2>Detail pesan</h2>
            <dl class="meta" style="margin-bottom: 18px">
                <dt>Nama</dt><dd>{{ $message->name }}</dd>
                @if ($message->email)<dt>Email</dt><dd><a href="mailto:{{ $message->email }}">{{ $message->email }}</a></dd>@endif
                @if ($message->phone)<dt>WhatsApp / HP</dt><dd>{{ $message->phone }}</dd>@endif
                <dt>Instansi / usaha</dt><dd>{{ $message->institution ?: '—' }}</dd>
                <dt>Layanan</dt><dd>{{ $message->service ?: '—' }}</dd>
            </dl>
            <div class="message-body">{{ $message->message }}</div>
        </section>
    </div>

    <div class="side-col">
        <form method="POST" action="{{ route('admin.messages.update', $message) }}" class="panel form">
            @csrf @method('PUT')
            <h2 style="margin: 0">Tindak lanjut</h2>
            <x-admin.select name="status" label="Status" :options="\App\Models\Message::STATUSES" :value="$message->status" />
            <x-admin.textarea name="admin_notes" label="Catatan internal" :value="$message->admin_notes" rows="5" hint="Misalnya: sudah dihubungi, kirim penawaran tanggal …" />
            <button class="btn btn-primary">Simpan</button>
        </form>
        <div class="panel" style="display: flex; flex-direction: column; gap: 10px">
            @if ($message->whatsappUrl())
                <a href="{{ $message->whatsappUrl() }}?text={{ rawurlencode("Assalamu'alaikum {$message->name}, terima kasih telah menghubungi {$site['site_name']}. ") }}" target="_blank" rel="noopener" class="btn btn-light"><x-icon name="whatsapp" size="16" stroke="2" />Balas via WhatsApp</a>
            @endif
            @if ($message->email)
                <a href="mailto:{{ $message->email }}?subject={{ rawurlencode('Tanggapan dari '.$site['site_name']) }}" class="btn btn-light"><x-icon name="mail" size="16" stroke="2" />Balas via Email</a>
            @endif
            <x-admin.delete :action="route('admin.messages.destroy', $message)" label="Hapus pesan" />
        </div>
    </div>
</div>
@endsection
