<?php

namespace App\Models\Pivots;

use App\Models\Product;
use App\Models\Ingredient;
use Illuminate\Database\Eloquent\Relations\Pivot;

class IngredientProduct extends Pivot
{

    public $timestamps = false;

    protected $table = 'ingredient_product';

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }


}
