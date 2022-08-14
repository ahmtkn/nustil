<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Publishable
{

    public static function bootPublishable()
    {
        if (!\Route::is('dashboard.*')) {
            static::addGlobalScope('published', function (Builder $builder) {
                $builder->where('status', 'published');
            });
        }
    }

    public function scopeStatus(Builder $builder, $status)
    {
        return $builder->where('status', $status);
    }

    public function scopePublished(Builder $builder)
    {
        return $builder->status('published');
    }

    public function scopeOnlyDraft(Builder $builder)
    {
        return $builder->status('draft');
    }

    public function publish()
    {
        $this->status = 'published';
        $this->save();
    }

    public function draft()
    {
        $this->status = 'draft';
        $this->save();
    }


}
