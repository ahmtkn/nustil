<?php


use App\Helpers\LocalizationHelper;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use Uutkukorkmaz\RouteOrganizer\Organizer;

$localePrefix = LocalizationHelper::prefix((string)Request::segment(1));

Route::view($localePrefix.'/dashboard', 'dashboard')
    ->name('dashboard');

Route::group(['prefix' => $localePrefix.'/dashboard', 'as' => 'dashboard.'], function () {
    Organizer::register([
        \App\Routes\Dashboard\MenuRoutes::class,
        \App\Routes\Dashboard\UserRoutes::class,
        \App\Routes\Dashboard\CategoryRoutes::class,
        \App\Routes\Dashboard\ProductRoutes::class,
        \App\Routes\Dashboard\BlogRoutes::class,
        \App\Routes\Dashboard\SlideRoutes::class,
        \App\Routes\Dashboard\SettingsRoutes::class,
        \App\Routes\Dashboard\CommentRoutes::class,
        \App\Routes\Dashboard\ImageRoutes::class,
        \App\Routes\Dashboard\PageRoutes::class,
        \App\Routes\Dashboard\RecipeRoutes::class,
        \App\Routes\Dashboard\MediaRoutes::class,
    ]);
    Route::get('/redirects', [\App\Http\Controllers\RedirectController::class, 'list'])->name('redirects');
    Route::post('/redirects/capture', [\App\Http\Controllers\RedirectController::class, 'redirect'])->name('redirects.store');
    Route::get('/redirects/{redirect}/release', [\App\Http\Controllers\RedirectController::class, 'delete'])->name(
        'redirects.delete'
    );
});


