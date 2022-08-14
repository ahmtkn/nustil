<?php

namespace App\Routes\Dashboard;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;
use Uutkukorkmaz\RouteOrganizer\Contracts\RouteContract;

class ImageRoutes implements RouteContract
{

    public static function register(): void
    {
        Route::group(['prefix' => 'images', 'as' => 'image.'], function () {
            Route::post('/', ImageController::class)->name('upload');
        });
    }

}
