<?php

namespace App\Models;

use App\Traits\HasLocalizedItems;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{

    use HasLocalizedItems;

    protected $fillable = [
        'name',
        'is_vegan',
        'contains_gluten',
        'is_nuts',
        'is_organic',
        'is_saturated_fat',
        'locale',
    ];

    protected $casts = [
        'is_vegan' => 'boolean',
        'contains_gluten' => 'boolean',
        'is_nuts' => 'boolean',
        'is_organic' => 'boolean',
        'is_saturated_fat' => 'boolean',
    ];

}
