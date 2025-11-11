<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Tags\HasTags;

class Card extends Model implements HasMedia
{
    use HasFactory;
    use HasTags;
    use InteractsWithMedia;

    protected $fillable = ['title', 'text', 'summary_en', 'summary_es'];

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Fit::Contain, 300, 300)
            ->nonQueued();
    }

    public function scopeSearch(Builder $query, $search): Builder
    {
        $search = mb_strtolower($search);

        return $query->where(
            fn($query) => $query
                ->whereRaw('LOWER(title) like ?', ["%{$search}%"])
                ->orWhereRaw('LOWER(text) like ?', ["%{$search}%"])
                ->orWhereHas('tags', fn($query) => $query->whereRaw('LOWER(name->\'$.' . app()->getLocale() . '\') like ?', ["%{$search}%"]))
        );
    }
}
