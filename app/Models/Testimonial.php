<?php

namespace App\Models;

use App\Models\Concerns\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Testimonial extends Model
{
    use Sortable;

    protected $fillable = [
        'name', 'position', 'organization', 'content', 'rating', 'photo', 'sort_order', 'is_active',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean', 'rating' => 'integer'];
    }

    public function initials(): string
    {
        $source = trim(preg_replace('/[\[\]]/', '', $this->name)) ?: 'K';

        return Str::upper(collect(explode(' ', $source))->filter()->take(2)->map(fn ($w) => Str::substr($w, 0, 1))->implode(''));
    }

    public function photoUrl(): ?string
    {
        return $this->photo ? Storage::disk('public')->url($this->photo) : null;
    }
}
