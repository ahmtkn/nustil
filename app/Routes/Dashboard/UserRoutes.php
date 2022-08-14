<?php

namespace App\Routes\Dashboard;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\UserController;
use Uutkukorkmaz\RouteOrganizer\Contracts\RouteContract;

class UserRoutes implements RouteContract
{

    public static function register(): void
    {
        Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
            Route::get('/', [UserController::class, 'index'])
                ->middleware('can:users.read')
                ->name('index');

            Route::get('new', [UserController::class, 'create'])
                ->middleware('can:users.create')
                ->name('create');

            Route::post('store', [UserController::class, 'store'])
                ->middleware('can:users.create')
                ->name('store');

            Route::group(['prefix' => '{user}'], function () {
                Route::get('edit', [UserController::class, 'edit'])
                    ->middleware('can:users.update')
                    ->name('edit');

                Route::patch('update', [UserController::class, 'update'])
                    ->middleware('can:users.update')
                    ->name('update');

                Route::delete('delete', [UserController::class, 'destroy'])
                    ->middleware('can:users.delete')
                    ->name('delete');

                Route::get('settings', [UserController::class, 'settings'])
                    ->name('settings');

                Route::patch('settings', [UserController::class, 'updateSettings'])
                    ->name('settings.update');
            });
        });
    }

}
