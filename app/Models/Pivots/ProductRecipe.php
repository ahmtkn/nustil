<?php

namespace App\Models\Pivots;

use App\Models\Recipe;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductRecipe extends Pivot
{
    protected $fillable = [
        'product_id',
        'recipe_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
}
