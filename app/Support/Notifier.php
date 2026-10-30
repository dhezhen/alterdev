<?php

namespace App\Support;

use App\Models\Message;
use App\Models\TrainingRegistration;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

/**
 * Mengirim notifikasi email ke admin bila NOTIFY_EMAIL diisi di .env.
 * Kegagalan pengiriman tidak menggagalkan proses simpan data.
 */
class Notifier
{
    public static function newMessage(Message $message): void
    {
        $body = "Pesan baru dari website\n\n"
            ."Nama      : {$message->name}\n"
            .'Kontak    : '.($message->email ?? $message->phone)."\n"
            .'Instansi  : '.($message->institution ?: '-')."\n"
            .'Layanan   : '.($message->service ?: '-')."\n\n"
            ."{$message->message}\n\n"
            .'Lihat di panel admin: '.route('admin.messages.show', $message);

        self::send('Pesan baru: '.$message->name, $body);
    }

    public static function newRegistration(TrainingRegistration $registration): void
    {
        $registration->loadMissing('schedule.training');
        $schedule = $registration->schedule;

        $body = "Pendaftaran pelatihan baru\n\n"
            ."Kode      : {$registration->code}\n"
            ."Pelatihan : {$schedule->training->title} ({$schedule->batch_name})\n"
            .'Tanggal   : '.$schedule->dateLabel()."\n"
            ."Nama      : {$registration->name}\n"
            ."Email     : {$registration->email}\n"
            ."HP/WA     : {$registration->phone}\n"
            .'Instansi  : '.($registration->institution ?: '-')."\n\n"
            .'Lihat di panel admin: '.route('admin.registrations.show', $registration);

        self::send('Pendaftar baru: '.$schedule->training->title, $body);
    }

    private static function send(string $subject, string $body): void
    {
        $to = config('app.notify_email');
        if (! $to) {
            return;
        }

        try {
            $subject = preg_replace('/[\r\n]+/', ' ', $subject);
            Mail::raw($body, fn ($m) => $m->to($to)->subject('['.config('app.name').'] '.$subject));
        } catch (Throwable $e) {
            Log::warning('Gagal mengirim notifikasi email: '.$e->getMessage());
        }
    }
}
