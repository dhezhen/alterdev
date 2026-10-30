<?php

namespace App\Models;

use App\Models\Concerns\HasSlug;
use App\Models\Concerns\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Training extends Model
{
    use HasSlug, Sortable;

    protected $fillable = [
        'title', 'slug', 'icon', 'summary', 'description', 'audience',
        'duration', 'outcomes', 'sort_order', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'outcomes' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(TrainingSchedule::class)->orderBy('start_date');
    }

    public function upcomingSchedules(): HasMany
    {
        return $this->schedules()
            ->where('status', 'open')
            ->whereDate('start_date', '>=', now()->toDateString());
    }
}
