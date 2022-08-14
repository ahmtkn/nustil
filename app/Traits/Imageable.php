<?php

namespace App\Traits;

use App\Models\Image;

trait Imageable
{

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable')->latest();
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

}
