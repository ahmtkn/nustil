<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Redirect extends Model
{

    protected $fillable = [
        'deprecated',
        'current',
        'status',
    ];

    public function scopeDeprecated(Builder $builder, string $requested): Builder
    {
        return $builder->where('deprecated', $requested);
    }

}
