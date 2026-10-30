<?php

namespace App\Models;

use App\Models\Concerns\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TeamMember extends Model
{
    use Sortable;

    protected $fillable = ['name', 'position', 'bio', 'photo', 'linkedin', 'sort_order', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function initials(): string
    {
        return Str::upper(collect(explode(' ', $this->name))->filter()->take(2)->map(fn ($w) => Str::substr($w, 0, 1))->implode(''));
    }

    public function photoUrl(): ?string
    {
        return $this->photo ? Storage::disk('public')->url($this->photo) : null;
    }
}
