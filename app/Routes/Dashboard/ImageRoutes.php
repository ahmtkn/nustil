<?php

namespace App\Routes\Dashboard;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;


class ImageRoutes implements \Uutkukorkmaz\RouteOrganizer\RegistersRouteGroup
{

    public static function register(): void
    {
        Route::group(['prefix' => 'images', 'as' => 'image.'], function () {
            Route::post('/', ImageController::class)->name('upload');
        });
    }

}
