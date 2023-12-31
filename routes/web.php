<?php

use App\Routes\BlogRoutes;
use App\Routes\RootRoutes;
use App\Routes\ProductRoutes;
use App\Routes\CategoryRoutes;
use App\Helpers\LocalizationHelper;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\PageController;
use App\Http\Controllers\MediaController;
use Uutkukorkmaz\RouteOrganizer\Organizer;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('landing');
})->name('root');
Route::get('sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'sitemaps'])->name('sitemaps');
$localePrefix = LocalizationHelper::prefix((string)Request::segment(1));

Route::get('media/{image:token}', MediaController::class)
    ->name('media');

require __DIR__.'/dashboard.php';

Route::group(['prefix' => $localePrefix], function () {
    Organizer::register([
        RootRoutes::class,
        CategoryRoutes::class,
        ProductRoutes::class,
        BlogRoutes::class,
    ]);

    require __DIR__.'/auth.php';

    Route::get('sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');
    Route::get('{type}-sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'custom'])->name('custom-sitemap');

    Route::get('{page:slug}', PageController::class)
        ->name('page');
});

Route::get('/{any}', \App\Http\Controllers\RedirectController::class)->where('any', '.*')->name('redirector');


