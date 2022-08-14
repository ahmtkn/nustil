<?php

namespace App\Routes;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use Uutkukorkmaz\RouteOrganizer\Contracts\RouteContract;

class CategoryRoutes implements RouteContract
{

    public static function register(): void
    {
        Route::group(['prefix' => __('route.category'), 'as' => 'category.'], function () {
            Route::get(__('route.all'), [CategoryController::class, 'index'])->name('index');
            Route::get('{category:slug}', [CategoryController::class, 'show'])->name('show');
        });
    }

}
