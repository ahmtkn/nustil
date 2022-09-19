<?php

namespace App\Routes;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;


class ProductRoutes implements \Uutkukorkmaz\RouteOrganizer\RegistersRouteGroup
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
