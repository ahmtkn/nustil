<?php

namespace App\Routes\Dashboard;


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\MediaController;
use Uutkukorkmaz\RouteOrganizer\Contracts\RouteContract;

class MediaRoutes implements RouteContract {

    public static function register(): void {
        Route::group(['prefix' => 'media', 'as' => 'media.'], function () {
            Route::get('/', [MediaController::class, 'album'])->name('index');
            Route::get('/create', [MediaController::class, 'create'])->name('create');
            Route::post('/', [MediaController::class, 'store'])->name('store');
            Route::get('/{media}/edit', [MediaController::class, 'edit'])->name('edit');
            Route::put('/{media}', [MediaController::class, 'update'])->name('update');
            Route::delete('/{media}', [MediaController::class, 'destroy'])->name('destroy');
        });
    }

}
