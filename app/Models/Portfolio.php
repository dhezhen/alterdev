<?php

namespace App\Models;

use App\Models\Concerns\HasSlug;
use App\Models\Concerns\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Portfolio extends Model
{
    use HasSlug, Sortable;

    public const CATEGORIES = ['Website', 'Sistem Informasi', 'Aplikasi', 'Pelatihan IT'];

    protected $fillable = [
        'title', 'slug', 'category', 'client', 'year', 'summary', 'challenge',
        'solution', 'result', 'tags', 'image', 'url', 'is_featured', 'sort_order', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'tags' => 'array',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function imageUrl(): ?string
    {
        return $this->image ? Storage::disk('public')->url($this->image) : null;
    }
}
