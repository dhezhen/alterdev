<?php

namespace App\Models\Concerns;

use Illuminate\Support\Str;

/**
 * Membuat slug unik otomatis dari kolom title bila slug kosong.
 */
trait HasSlug
{
    protected static function bootHasSlug(): void
    {
        static::saving(function ($model) {
            if (blank($model->slug)) {
                $model->slug = $model->title;
            }
            $model->slug = static::uniqueSlug(Str::slug($model->slug), $model->getKey());
        });
    }

    protected static function uniqueSlug(string $base, $ignoreId = null): string
    {
        $base = $base !== '' ? $base : Str::random(8);
        $slug = $base;
        $i = 2;

        while (static::query()
            ->where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where((new static)->getKeyName(), '!=', $ignoreId))
            ->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
