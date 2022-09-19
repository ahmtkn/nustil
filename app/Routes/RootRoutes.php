<?php

namespace App\Routes;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;


class RootRoutes implements \Uutkukorkmaz\RouteOrganizer\RegistersRouteGroup {

    public static function register(): void {
        Route::get('/', LandingController::class)->name('landing');
    }

}
