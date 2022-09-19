<?php

namespace App\Routes\Dashboard;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\RecipeController;


class RecipeRoutes implements \Uutkukorkmaz\RouteOrganizer\RegistersRouteGroup {

    public static function register(): void {
        Route::resource('recipes',RecipeController::class)->except('show');
    }

}
