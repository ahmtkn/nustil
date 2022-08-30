<?php

namespace App\Routes;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use Uutkukorkmaz\RouteOrganizer\Contracts\RouteContract;

class PageRoutes implements RouteContract
{

    public static function register(): void
    {
        Route::get('{page:slug}', PageController::class)->name('page');
    }

}
