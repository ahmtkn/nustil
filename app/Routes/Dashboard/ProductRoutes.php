<?php

namespace App\Routes\Dashboard;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\ProductController;

use App\Http\Controllers\Dashboard\IngredientController;

class ProductRoutes implements \Uutkukorkmaz\RouteOrganizer\RegistersRouteGroup
{

    public static function register(): void
    {
        Route::group(['prefix' => 'products', 'as' => 'products.'], function () {
            Route::get('/', [ProductController::class, 'index'])
                ->middleware('can:products.read')
                ->name('index');

            Route::get('new', [ProductController::class, 'create'])
                ->middleware('can:products.create')
                ->name('create');

            Route::get('{product}/edit', [ProductController::class, 'edit'])
                ->middleware('can:products.update')
                ->name('edit');

            Route::post('/', [ProductController::class, 'store'])
                ->middleware('can:products.create')
                ->name('store');

            Route::put('/{product}', [ProductController::class, 'update'])
                ->middleware('can:products.update')
                ->name('update');

            Route::delete('/{product}', [ProductController::class, 'destroy'])
                ->middleware('can:products.delete')
                ->name('delete');
        });
        Route::group(['prefix' => 'ingredients', 'as' => 'ingredients.'], function () {
            Route::get('/', [IngredientController::class, 'index'])
                ->middleware('can:products.read')
                ->name('index');
            Route::get('new', [IngredientController::class, 'create'])
                ->middleware('can:products.create')
                ->name('create');
            Route::post('/', [IngredientController::class, 'store'])
                ->middleware('can:products.create')
                ->name('store');
            Route::group(['prefix' => '{ingredient}'], function () {
                Route::get('edit', [IngredientController::class, 'edit'])
                    ->middleware('can:products.update')
                    ->name('edit');
                Route::put('/', [IngredientController::class, 'update'])
                    ->middleware('can:products.update')
                    ->name('update');
                Route::delete('/', [IngredientController::class, 'destroy'])
                    ->middleware('can:products.delete')
                    ->name('delete');
            });
        });
    }

}
