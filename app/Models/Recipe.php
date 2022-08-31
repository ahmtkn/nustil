<?php

namespace App\Models;

use App\Traits\Viewable;
use App\Traits\Imageable;
use App\Traits\HasLocalizedItems;
use App\Models\Pivots\ProductRecipe;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{

    use HasFactory, Viewable, Imageable, HasLocalizedItems;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'ingredients',
        'instructions',
        'notes',
        'locale',
    ];

    protected $casts = [
        'ingredients' => 'array',
        'instructions' => 'array',
        'notes' => 'array',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->using(ProductRecipe::class)
            ->orderByDesc('id');
    }

}
