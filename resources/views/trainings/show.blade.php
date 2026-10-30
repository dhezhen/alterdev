@extends('layouts.app')

@section('title', $training->title)
@section('description', $training->summary)

@section('content')
@include('partials.page-hero', [
    'eyebrow' => 'Program Pelatihan',
    'title' => $training->title,
    'text' => $training->summary,
    'crumbs' => ['Pelatihan' => route('trainings.index'), $training->title => null],
])

<section class="section" style="padding-top: 0">
    <div class="container layout-side">
        <div class="main stack" style="gap: 28px">
            <article class="box glass prose" style="padding: 40px">
                {!! \Illuminate\Support\Str::markdown($training->description ?: $training->summary, ['html_input' => 'strip', 'allow_unsafe_links' => false]) !!}
                @if ($training->outcomes)
                    <h2>Yang akan Anda dapatkan</h2>
                    <ul>@foreach ($training->outcomes as $outcome)<li>{{ $outcome }}</li>@endforeach</ul>
                @endif
            </article>

            <div class="stack" id="jadwal" style="gap: 20px">
                <h2 class="title-md">Jadwal &amp; Pendaftaran</h2>

                @if (session('error'))
                    <div class="alert alert-error" role="alert">{{ session('error') }}</div>
                @endif

                @forelse ($schedules as $schedule)
                    <div id="daftar-{{ $schedule->id }}" class="stack" style="gap: 16px">
                        @include('trainings.partials.schedule', ['showTraining' => false])
                        @if ($schedule->notes)
                            <p class="small" style="padding: 0 6px">{{ $schedule->notes }}</p>
                        @endif
                        @if ($schedule->isOpenForRegistration())
                            <details class="faq neu-sm" @if (old('schedule_id') == $schedule->id || $schedules->count() === 1) open @endif>
                                <summary>Isi formulir pendaftaran — {{ $schedule->batch_name }}<span class="sign neu-in" aria-hidden="true"></span></summary>
                                <form method="POST" action="{{ route('trainings.register', $schedule) }}" class="form" style="padding: 0 24px 24px" novalidate>
                                    @csrf
                                    <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                                    <div class="hp" aria-hidden="true"><label>Jangan diisi <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
                                    @php $isThis = old('schedule_id') == $schedule->id; @endphp
                                    <div class="form-grid">
                                        <label class="field">Nama lengkap
                                            <input class="input" type="text" name="name" value="{{ $isThis ? old('name') : '' }}" required>
                                            @if ($isThis) @error('name')<span class="error">{{ $message }}</span>@enderror @endif
                                        </label>
                                        <label class="field">Email
                                            <input class="input" type="email" name="email" value="{{ $isThis ? old('email') : '' }}" required>
                                            @if ($isThis) @error('email')<span class="error">{{ $message }}</span>@enderror @endif
                                        </label>
                                    </div>
                                    <div class="form-grid">
                                        <label class="field">No. HP / WhatsApp
                                            <input class="input" type="tel" name="phone" value="{{ $isThis ? old('phone') : '' }}" required>
                                            @if ($isThis) @error('phone')<span class="error">{{ $message }}</span>@enderror @endif
                                        </label>
                                        <label class="field">Instansi / Lembaga
                                            <input class="input" type="text" name="institution" value="{{ $isThis ? old('institution') : '' }}" placeholder="Opsional">
                                        </label>
                                    </div>
                                    <label class="field">Catatan
                                        <textarea class="input" name="notes" rows="3" placeholder="Opsional, misalnya kebutuhan khusus peserta">{{ $isThis ? old('notes') : '' }}</textarea>
                                    </label>
                                    <button type="submit" class="btn btn-primary" style="align-self: flex-start">Kirim Pendaftaran</button>
                                </form>
                            </details>
                        @endif
                    </div>
                @empty
                    <div class="empty neu-in">
                        Belum ada jadwal untuk program ini. <a href="{{ route('contact', ['layanan' => 'Pelatihan IT']) }}">Hubungi kami</a> untuk mengajukan jadwal atau pelatihan in-house.
                    </div>
                @endforelse
            </div>
        </div>

        <aside class="side">
            <div class="neu" style="border-radius: 26px; padding: 28px; display: flex; flex-direction: column; gap: 16px">
                <span class="icon-box neu-in"><x-icon :name="$training->icon" size="26" stroke="1.8" /></span>
                <dl style="margin: 0; display: grid; gap: 12px; font-size: 14.5px">
                    @if ($training->audience)<div><dt class="small">Cocok untuk</dt><dd style="margin: 2px 0 0; font-weight: 600">{{ $training->audience }}</dd></div>@endif
                    @if ($training->duration)<div><dt class="small">Durasi</dt><dd style="margin: 2px 0 0; font-weight: 600">{{ $training->duration }}</dd></div>@endif
                </dl>
                <a href="#jadwal" class="btn btn-primary btn-sm">Lihat Jadwal</a>
                <a href="{{ route('contact', ['layanan' => 'Pelatihan IT']) }}" class="btn btn-soft btn-sm">Ajukan In-house Training</a>
            </div>
            @if ($others->isNotEmpty())
                <div class="neu-sm" style="border-radius: 22px; padding: 22px; display: flex; flex-direction: column; gap: 8px">
                    <strong style="font-size: 15px; margin-bottom: 4px">Program lainnya</strong>
                    @foreach ($others as $other)
                        <a href="{{ route('trainings.show', $other) }}" style="display: flex; gap: 10px; align-items: center; padding: 8px 0; text-decoration: none; color: var(--ink); font-weight: 600; font-size: 14.5px">
                            <span class="accent"><x-icon :name="$other->icon" size="18" stroke="2" /></span>{{ $other->title }}
                        </a>
                    @endforeach
                </div>
            @endif
        </aside>
    </div>
</section>
@endsection
