<?php

namespace App\Routes\Dashboard;

use App\Models\Page;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\PageController;
use Uutkukorkmaz\RouteOrganizer\Contracts\RouteContract;

class PageRoutes implements RouteContract
{

    public static function register(): void
    {
        Route::resource('pages', PageController::class)->except('show', 'index');

        Route::get('pages/{filter?}', [PageController::class, 'index'])->name('pages.index');

        Route::bind('page', function ($value) {
            if (auth()->check() && Route::is('dashboard.*')) {
                return Page::withTrashed()
                    ->whereId($value)
                    ->firstOrFail();
            }

            return Page::withoutTrashed()
                ->whereSlug($value)
                ->locale(app()->getLocale())
                ->firstOrFail();
        });
    }

}
