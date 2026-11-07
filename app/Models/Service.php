<?php

namespace App\Models;

use App\Models\Concerns\HasSlug;
use App\Models\Concerns\Sortable;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasSlug, Sortable;

    protected $fillable = [
        'title', 'slug', 'icon', 'short_description', 'description',
        'features', 'price_label', 'pricing_packages', 'portfolio_category', 'sort_order', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'features' => 'array',
            'pricing_packages' => 'array',
            'is_active' => 'boolean',
        ];
    }
}
