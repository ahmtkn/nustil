<?php

namespace App\Models\Pivots;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CategoryProduct extends Pivot
{

    public $timestamps = false;

    protected $table = 'category_product';

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
