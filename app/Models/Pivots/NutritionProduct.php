<?php

namespace App\Models\Pivots;

use App\Models\Product;
use App\Models\Nutrition;
use Illuminate\Database\Eloquent\Relations\Pivot;

class NutritionProduct extends Pivot
{

    protected $table = 'nutrition_product';

    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'nutrition_id',
        'value',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function nutrition()
    {
        return $this->belongsTo(Nutrition::class);
    }

}
