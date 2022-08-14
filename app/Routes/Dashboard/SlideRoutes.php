<?php

namespace App\Routes\Dashboard;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\SlideController;
use Uutkukorkmaz\RouteOrganizer\Contracts\RouteContract;

class SlideRoutes implements RouteContract
{

    public static function register(): void
    {
        Route::group(['prefix' => 'slides', 'as' => 'slides.'], function () {
            Route::get('/', [SlideController::class, 'index'])
                ->middleware('can:menus.read')
                ->name('index');

            Route::get('create', [SlideController::class, 'create'])
                ->middleware('can:menus.create')
                ->name('create');

            Route::post('store', [SlideController::class, 'store'])
                ->middleware('can:menus.create')
                ->name('store');

            Route::group(['prefix' => '{slide}'], function () {
                Route::get('edit', [SlideController::class, 'edit'])
                    ->middleware('can:menus.update')
                    ->name('edit');

                Route::put('update', [SlideController::class, 'update'])
                    ->middleware('can:menus.update')
                    ->name('update');

                Route::delete('delete',[SlideController::class,'destroy'])
                    ->middleware('can:menus.delete')
                    ->name('delete');
            });
        });
    }

}
