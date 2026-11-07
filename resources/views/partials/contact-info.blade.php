@php
    $waNumbers = collect([
        $site['contact_whatsapp'] ?? '',
        $site['contact_whatsapp_secondary'] ?? '',
    ])->filter(fn ($number) => trim($number) !== '');
@endphp
<div class="stack" style="gap: 14px; padding-top: 8px">
    @foreach ($waNumbers as $number)
        @php $waDigits = preg_replace('/\D/', '', $number); @endphp
        @if (strlen($waDigits) >= 9)
            <a href="https://wa.me/{{ $waDigits }}" target="_blank" rel="noopener" class="contact-item neu-sm"><x-icon name="whatsapp" size="20" stroke="2" />{{ $number }}</a>
        @else
            <span class="contact-item neu-sm"><x-icon name="whatsapp" size="20" stroke="2" />{{ $number }}</span>
        @endif
    @endforeach
    @if (filter_var($site['contact_email'], FILTER_VALIDATE_EMAIL))
        <a href="mailto:{{ $site['contact_email'] }}" class="contact-item neu-sm"><x-icon name="mail" size="20" stroke="2" />{{ $site['contact_email'] }}</a>
    @else
        <span class="contact-item neu-sm"><x-icon name="mail" size="20" stroke="2" />{{ $site['contact_email'] }}</span>
    @endif
    <span class="contact-item neu-sm"><x-icon name="pin" size="20" stroke="2" />{{ $site['contact_address'] }}</span>
    <span class="contact-item neu-sm"><x-icon name="clock" size="20" stroke="2" />{{ $site['contact_hours'] }}</span>
</div>
