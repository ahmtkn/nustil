<?php

namespace App\Models;

use App\Traits\HasChildren;
use App\Traits\HasLocalizedItems;
use App\Models\Pivots\CategoryProduct;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\CurrentLocaleScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{

    use HasFactory, HasLocalizedItems, HasChildren;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'locale',
        'parent_id',
    ];

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CurrentLocaleScope);
    }

    /**
     * The relation that has many products.
     *
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->using(CategoryProduct::class)->latest();
    }


}
