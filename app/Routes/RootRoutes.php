<?php

namespace App\Routes;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use Uutkukorkmaz\RouteOrganizer\Contracts\RouteContract;

class RootRoutes implements RouteContract {

    public static function register(): void {
        Route::get('/', LandingController::class)->name('landing');
    }

}
