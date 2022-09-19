<?php

namespace App\Routes;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;


class PageRoutes implements \Uutkukorkmaz\RouteOrganizer\RegistersRouteGroup
{

    public static function register(): void
    {
        Route::get('{page:slug}', PageController::class)->name('page');
    }

}
