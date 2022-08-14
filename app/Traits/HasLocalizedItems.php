<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;


trait HasLocalizedItems
{

    /**
     * Get the data by locale.
     *
     * @param  Builder  $builder
     * @param  string  $locale
     *
     * @return Builder
     */
    public function scopeLocale(Builder $builder, $locale): Builder
    {
        return $builder->where('locale', $locale);
    }


}
