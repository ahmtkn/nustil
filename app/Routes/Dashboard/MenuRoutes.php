<?php

namespace App\Routes\Dashboard;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\MenuController;
use Uutkukorkmaz\RouteOrganizer\Contracts\RouteContract;

class MenuRoutes implements RouteContract
{

    public static function register(): void
    {
        Route::group(['prefix' => 'menus', 'as' => 'menus.'], function () {
            Route::get('/', [MenuController::class, 'index'])
                ->middleware('can:menus.read')
                ->name('index');

            Route::group(['prefix' => '{group}'], function () {
                Route::get('/', [MenuController::class, 'show'])
                    ->middleware('can:menus.read')
                    ->name('show');

                Route::post('/', [MenuController::class, 'create'])
                    ->middleware('can:menus.create')
                    ->name('create');

                Route::get('move/{menu}/{direction}', [MenuController::class, 'move'])
                    ->middleware('can:menus.update')
                    ->name('move');

                Route::patch('update/{menu}', [MenuController::class, 'update'])
                    ->middleware('can:menus.update')
                    ->name('update');

                Route::delete('delete/{menu}', [MenuController::class, 'destroy'])
                    ->middleware('can:menus.delete')
                    ->name('delete');
            });
        });
    }

}
