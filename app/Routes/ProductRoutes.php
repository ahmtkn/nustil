<?php

namespace App\Routes;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use Uutkukorkmaz\RouteOrganizer\Contracts\RouteContract;

class ProductRoutes implements RouteContract
{

    public static function register(): void
    {
        Route::group(['prefix' => __('route.product'), 'as' => 'product.'], function () {
            Route::get('{product:slug}', ProductController::class)->name('show');
            Route::get('{product:slug}/'.__('route.recipes').'/{recipe:slug}', [ProductController::class, 'recipe'])
                ->name('recipe.show');
        });
    }

}
