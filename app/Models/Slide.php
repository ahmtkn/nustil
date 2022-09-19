<?php

namespace App\Models;

use App\Traits\Imageable;
use App\Traits\HasLocalizedItems;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Slide extends Model
{

    use Imageable;
    use HasLocalizedItems;

    protected $fillable = [
        'title',
        'subtitle',
        'buttons',
        'published_at',
        'expires_at',
        'locale',
    ];

    protected $casts = [
        'buttons' => 'json',
    ];

    protected $dates = [
        'published_at',
        'expires_at',
    ];

    public function scopeActive(Builder $builder)
    {
        return $builder->where('published_at', '<=', now())
            ->where(function ($query) {
                $query->where('expires_at', null)
                    ->orWhere('expires_at', '>', now());
            });
    }

    public function isActive()
    {
        return $this->published_at <= now() && ($this->expires_at == null || $this->expires_at >= now());
    }

    public function srcSet()
    {
        if (!$this->relationLoaded('images')) {
            $this->load('images');
        }
        $images = $this->images;
        $srcSet = [];
        foreach ($images as $image) {
            $width = explode(' ', $image->type)[1];
            $srcSet[] = $image->url.' '.$width;
        }

        return implode(', ', $srcSet);
    }

    public function getDesktopImage($returnUrl = true)
    {
        $img = $this->image()->where('type', 'desktop')->first();

        return $returnUrl ? ($img ? $img->url : '#') : $img;
    }

    public function getMobileImage($returnUrl = true)
    {
        $img = $this->image()->where('type', 'mobile')->first();

        return $returnUrl ? ($img ? $img->url : '#') : $img;
    }

    public function slideImages()
    {
        return $this->images()->get()->groupBy('type');
    }

}
