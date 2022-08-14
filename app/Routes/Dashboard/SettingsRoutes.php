<?php

namespace App\Routes\Dashboard;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\SettingsController;
use Uutkukorkmaz\RouteOrganizer\Contracts\RouteContract;

class SettingsRoutes implements RouteContract
{

    public static function register(): void
    {
        Route::group(['prefix' => 'settings', 'as' => 'settings.', 'middleware' => ['can:settings.update']],
            function () {
                Route::get('/', [SettingsController::class, 'index'])->name('index');
                Route::put('/', [SettingsController::class, 'update'])->name('update');
                Route::delete('/', [SettingsController::class, 'reset'])->name('reset');
            });
    }

}
