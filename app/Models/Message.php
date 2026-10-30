<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public const STATUSES = [
        'new' => 'Baru',
        'in_progress' => 'Ditindaklanjuti',
        'done' => 'Selesai',
        'archived' => 'Diarsipkan',
    ];

    public const SERVICES = [
        'Website Company Profile',
        'Sistem Informasi',
        'Pembuatan Aplikasi',
        'Pelatihan IT',
        'Pendampingan Yayasan / Pesantren / Sekolah',
        'Belum tahu, ingin konsultasi',
    ];

    protected $fillable = [
        'name', 'email', 'phone', 'institution', 'service', 'message',
        'status', 'admin_notes', 'ip_address', 'read_at',
    ];

    protected function casts(): array
    {
        return ['read_at' => 'datetime'];
    }

    public function statusLabel(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

    /** Tautan WhatsApp untuk membalas, bila nomor tersedia. */
    public function whatsappUrl(): ?string
    {
        if (! $this->phone) {
            return null;
        }
        $number = preg_replace('/\D/', '', $this->phone);
        if (str_starts_with($number, '0')) {
            $number = '62'.substr($number, 1);
        }

        return 'https://wa.me/'.$number;
    }
}
