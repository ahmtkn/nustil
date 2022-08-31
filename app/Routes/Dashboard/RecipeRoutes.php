<?php

namespace App\Routes\Dashboard;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\RecipeController;
use Uutkukorkmaz\RouteOrganizer\Contracts\RouteContract;

class RecipeRoutes implements RouteContract {

    public static function register(): void {
        Route::resource('recipes',RecipeController::class)->except('show');
    }

}
