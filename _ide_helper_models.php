<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Category
 *
 * @property int $id
 * @property string $name
 * @property string|null $locale
 * @property string $slug
 * @property string|null $description
 * @property int|null $parent_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Category[] $children
 * @property-read int|null $children_count
 * @property-read Category|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @method static \Database\Factories\CategoryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Category locale($locale)
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Ingredient
 *
 * @property int $id
 * @property string $name
 * @property int $is_vegan
 * @property int $contains_gluten
 * @property int $is_nuts
 * @property int $is_dairy
 * @property int $is_saturated_fat
 * @property int $is_protective
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Ingredient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ingredient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ingredient query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ingredient whereContainsGluten($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ingredient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ingredient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ingredient whereIsDairy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ingredient whereIsNuts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ingredient whereIsProtective($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ingredient whereIsSaturatedFat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ingredient whereIsVegan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ingredient whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ingredient whereUpdatedAt($value)
 */
	class Ingredient extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Menu
 *
 * @property int $id
 * @property string $locale
 * @property string $method
 * @property string $to
 * @property string $title
 * @property string|null $group
 * @property array $payload
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Menu group(?string $group = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu locale(string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu query()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu wherePayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereUpdatedAt($value)
 */
	class Menu extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Nutrition
 *
 * @property int $id
 * @property string $name
 * @property int|null $parent_id
 * @property string|null $unit
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Nutrition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Nutrition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Nutrition query()
 * @method static \Illuminate\Database\Eloquent\Builder|Nutrition whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nutrition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nutrition whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nutrition whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nutrition whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nutrition whereUpdatedAt($value)
 */
	class Nutrition extends \Eloquent {}
}

namespace App\Models\Pivots{
/**
 * App\Models\Pivots\CategoryProduct
 *
 * @property int $product_id
 * @property int $category_id
 * @property-read \App\Models\Category $category
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryProduct whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryProduct whereProductId($value)
 */
	class CategoryProduct extends \Eloquent {}
}

namespace App\Models\Pivots{
/**
 * App\Models\Pivots\IngredientProduct
 *
 * @property int $product_id
 * @property int $ingredient_id
 * @property-read \App\Models\Ingredient $ingredient
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|IngredientProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IngredientProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IngredientProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|IngredientProduct whereIngredientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IngredientProduct whereProductId($value)
 */
	class IngredientProduct extends \Eloquent {}
}

namespace App\Models\Pivots{
/**
 * App\Models\Pivots\NutritionProduct
 *
 * @property int $product_id
 * @property int $nutrition_id
 * @property string $value
 * @property-read \App\Models\Nutrition $nutrition
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|NutritionProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NutritionProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NutritionProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|NutritionProduct whereNutritionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NutritionProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NutritionProduct whereValue($value)
 */
	class NutritionProduct extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $color
 * @property string $price
 * @property int $amount
 * @property int $is_pack
 * @property string|null $locale
 * @property string|null $tagline
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Category[] $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Ingredient[] $ingredients
 * @property-read int|null $ingredients_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Nutrition[] $nutritions
 * @property-read int|null $nutritions_count
 * @method static \Illuminate\Database\Eloquent\Builder|Product locale($locale)
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsPack($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTagline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

