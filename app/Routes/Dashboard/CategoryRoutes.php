<?php

namespace App\Routes\Dashboard;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\CategoryController;


class CategoryRoutes implements \Uutkukorkmaz\RouteOrganizer\RegistersRouteGroup
{

    public static function register(): void
    {
        Route::group(['prefix' => 'categories', 'as' => 'categories.'], function () {
            Route::get('/', [CategoryController::class, 'index'])
                ->middleware('can:categories.read')
                ->name('index');

            Route::get('/new', [CategoryController::class, 'create'])
                ->middleware('can:categories.create')
                ->name('create');

            Route::post('/', [CategoryController::class, 'store'])
                ->middleware('can:categories.create')
                ->name('store');

            Route::group(['prefix' => '{category}'], function () {

                Route::get('/edit', [CategoryController::class, 'edit'])
                    ->middleware('can:categories.update')
                    ->name('edit');

                Route::delete('/', [CategoryController::class, 'destroy'])
                    ->middleware('can:categories.delete')
                    ->name('delete');

                Route::put('/', [CategoryController::class, 'update'])
                    ->middleware('can:categories.update')
                    ->name('update');
            });
        });
    }

}
