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

    public function publishedPricingPackages(): array
    {
        return collect($this->pricing_packages ?? [])
            ->filter(fn ($package) => is_array($package) && (bool) ($package['is_published'] ?? false))
            ->map(fn (array $package) => [
                'name' => $package['name'] ?? '',
                'summary' => $package['summary'] ?? '',
                'price' => $package['price'] ?? null,
                'price_display' => $package['price_display'] ?? '',
                'price_kicker' => $package['price_kicker'] ?? '',
                'compare_price' => $package['compare_price'] ?? null,
                'compare_price_display' => $package['compare_price_display'] ?? '',
                'discount_label' => $package['discount_label'] ?? '',
                'price_note' => $package['price_note'] ?? '',
                'features' => $package['features'] ?? [],
                'excluded_features' => $package['excluded_features'] ?? [],
                'services' => $package['services'] ?? [],
                'renewal_label' => $package['renewal_label'] ?? '',
                'accent_color' => $package['accent_color'] ?? 'blue',
            ])
            ->values()
            ->all();
    }

    public function startingPricingPackage(): ?array
    {
        return collect($this->publishedPricingPackages())
            ->filter(fn (array $package) => is_numeric($package['price'] ?? null))
            ->sortBy(fn (array $package) => (int) $package['price'])
            ->first();
    }
}
