<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TrainingSchedule extends Model
{
    public const MODES = ['offline' => 'Tatap muka', 'online' => 'Daring', 'hybrid' => 'Hybrid'];

    public const STATUSES = ['open' => 'Pendaftaran dibuka', 'closed' => 'Pendaftaran ditutup', 'finished' => 'Selesai'];

    protected $fillable = [
        'training_id', 'batch_name', 'start_date', 'end_date', 'time_info', 'mode',
        'location', 'quota', 'price', 'registration_deadline', 'status', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'registration_deadline' => 'date',
            'quota' => 'integer',
            'price' => 'integer',
        ];
    }

    public function training(): BelongsTo
    {
        return $this->belongsTo(Training::class);
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(TrainingRegistration::class);
    }

    /** Jumlah pendaftar yang menempati kuota (tidak termasuk yang dibatalkan). */
    public function filledSeats(): int
    {
        return $this->registrations()->where('status', '!=', 'cancelled')->count();
    }

    public function remainingSeats(): int
    {
        return max(0, $this->quota - $this->filledSeats());
    }

    public function isOpenForRegistration(): bool
    {
        if ($this->status !== 'open') {
            return false;
        }
        if ($this->registration_deadline && $this->registration_deadline->copy()->endOfDay()->isPast()) {
            return false;
        }
        if ($this->start_date->copy()->endOfDay()->isPast()) {
            return false;
        }

        return $this->remainingSeats() > 0;
    }

    public function dateLabel(): string
    {
        $start = $this->start_date->translatedFormat('j F Y');
        if (! $this->end_date || $this->end_date->isSameDay($this->start_date)) {
            return $start;
        }

        return $this->start_date->translatedFormat('j M').' – '.$this->end_date->translatedFormat('j M Y');
    }

    public function priceLabel(): string
    {
        return $this->price > 0 ? 'Rp'.number_format($this->price, 0, ',', '.') : 'Gratis';
    }

    public function modeLabel(): string
    {
        return self::MODES[$this->mode] ?? $this->mode;
    }
}
