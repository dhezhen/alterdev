<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class TrainingRegistration extends Model
{
    public const STATUSES = [
        'pending' => 'Menunggu konfirmasi',
        'confirmed' => 'Terkonfirmasi',
        'cancelled' => 'Dibatalkan',
        'attended' => 'Hadir',
    ];

    protected $fillable = [
        'training_schedule_id', 'code', 'name', 'email', 'phone',
        'institution', 'notes', 'status', 'admin_notes',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $registration) {
            if (blank($registration->code)) {
                do {
                    $code = 'PLT-'.now()->format('ym').'-'.Str::upper(Str::random(8));
                } while (static::where('code', $code)->exists());
                $registration->code = $code;
            }
        });
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(TrainingSchedule::class, 'training_schedule_id');
    }

    public function statusLabel(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }
}
