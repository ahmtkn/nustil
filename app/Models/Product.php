<?php

namespace App\Models;

use App\Traits\Viewable;
use App\Traits\Imageable;
use App\Traits\Publishable;
use App\Traits\HasLocalizedItems;
use App\Models\Pivots\ProductRecipe;
use App\Models\Pivots\CategoryProduct;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pivots\NutritionProduct;
use App\Models\Pivots\IngredientProduct;
use App\Models\Scopes\CurrentLocaleScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{

    use Viewable;
    use Imageable;
    use HasFactory;
    use Publishable;
    use HasLocalizedItems;


    protected $fillable = [
        'name',
        'slug',
        'color',
        'weight',
        'price',
        'amount',
        'is_pack',
        'locale',
        'tagline',
        'description',
        'status',
        'purchase_link',
    ];

    public static function boot()
    {
        parent::boot();
        static::addGlobalScope(new CurrentLocaleScope());
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class)
            ->using(CategoryProduct::class);
    }


    public function nutritions()
    {
        return $this->belongsToMany(Nutrition::class)
            ->using(NutritionProduct::class)
            ->withPivot('value');
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class)
            ->using(IngredientProduct::class)
            ->where('locale', app()->getLocale());
    }

    public function recipes(){
        return $this->belongsToMany(Recipe::class)
            ->using(ProductRecipe::class)
            ->where('locale',app()->getLocale());
    }


    public function getImage(): string
    {
        return $this->image ? $this->image->url : asset('img/placeholder.png');
    }


    public function isGlutenFree(): bool
    {
        if (!$this->relationLoaded('ingredients')) {
            $this->load('ingredients');
        }

        return $this->ingredients->sum('contains_gluten') < 1;
    }

    public function isVegan(): bool
    {
        if (!$this->relationLoaded('ingredients')) {
            $this->load('ingredients');
        }


        return !$this->ingredients->where('is_vegan', 0)->count();
    }

    public function isOrganic()
    {
        if (!$this->relationLoaded('ingredients')) {
            $this->load('ingredients');
        }

        return !$this->ingredients->where('is_organic', 0)->count();
    }

}
