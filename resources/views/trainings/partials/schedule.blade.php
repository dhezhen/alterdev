{{-- Kartu jadwal pelatihan. Variabel: $schedule, $showTraining (bool) --}}
@php $open = $schedule->isOpenForRegistration(); $remaining = $schedule->remainingSeats(); @endphp
<article class="schedule neu-sm">
    <div style="display: flex; flex-wrap: wrap; gap: 10px; justify-content: space-between; align-items: center">
        <span class="status-chip {{ $open ? 'status-open' : 'status-closed' }}">{{ $open ? 'Pendaftaran dibuka' : ($remaining === 0 ? 'Kuota penuh' : 'Pendaftaran ditutup') }}</span>
        <strong class="accent">{{ $schedule->priceLabel() }}</strong>
    </div>
    <div>
        @if ($showTraining ?? false)
            <h3 style="font-size: 19px"><a href="{{ route('trainings.show', $schedule->training) }}" style="color: var(--ink); text-decoration: none">{{ $schedule->training->title }}</a></h3>
        @endif
        <p class="small" style="font-weight: 600; margin-top: 4px">{{ $schedule->batch_name }}</p>
    </div>
    <div class="schedule-meta">
        <div><x-icon name="calendar" size="17" stroke="2" />{{ $schedule->dateLabel() }}</div>
        @if ($schedule->time_info)<div><x-icon name="clock" size="17" stroke="2" />{{ $schedule->time_info }}</div>@endif
        <div><x-icon name="monitor" size="17" stroke="2" />{{ $schedule->modeLabel() }}</div>
        @if ($schedule->location)<div><x-icon name="pin" size="17" stroke="2" />{{ $schedule->location }}</div>@endif
        <div><x-icon name="users" size="17" stroke="2" />Sisa kuota {{ $remaining }} dari {{ $schedule->quota }}</div>
        @if ($schedule->registration_deadline)<div><x-icon name="calendar-check" size="17" stroke="2" />Daftar s.d. {{ $schedule->registration_deadline->translatedFormat('j F Y') }}</div>@endif
    </div>
    @if ($showTraining ?? false)
        <a href="{{ route('trainings.show', $schedule->training) }}#daftar-{{ $schedule->id }}" class="btn {{ $open ? 'btn-primary' : 'btn-soft' }} btn-sm" style="align-self: flex-start">{{ $open ? 'Daftar Sekarang' : 'Lihat Detail' }}</a>
    @endif
</article>
