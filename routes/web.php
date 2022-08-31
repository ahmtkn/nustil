<?php

use App\Routes\RootRoutes;
use App\Routes\BlogRoutes;
use App\Routes\ProductRoutes;
use App\Routes\CategoryRoutes;
use App\Helpers\LocalizationHelper;
use App\Routes\Dashboard\MenuRoutes;
use App\Routes\Dashboard\UserRoutes;
use App\Routes\Dashboard\PageRoutes as DashboardPageRoutes;
use App\Routes\Dashboard\CommentRoutes;
use App\Routes\Dashboard\BlogRoutes as DashboardBlogRoutes;
use App\Routes\Dashboard\ImageRoutes;
use App\Routes\Dashboard\SlideRoutes;
use App\Http\Controllers\MediaController;
use App\Routes\Dashboard\RecipeRoutes as DashboardRecipeRoutes;
use App\Routes\Dashboard\CategoryRoutes as DashboardCategoryRoutes;
use App\Routes\Dashboard\ProductRoutes as DashboardProductRoutes;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Routes\Dashboard\SettingsRoutes;
use Uutkukorkmaz\RouteOrganizer\Facades\Organizer;

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

$localePrefix = LocalizationHelper::prefix((string)(Request::segment(1)));

//Dashboard Routes
Route::view($localePrefix.'/dashboard', 'dashboard')->middleware(['auth'])->name('dashboard');
Route::group(['prefix' => $localePrefix.'/dashboard/', 'as' => 'dashboard.', 'middleware' => 'auth'], function () {
    Organizer::register([
        MenuRoutes::class,
        UserRoutes::class,
        DashboardCategoryRoutes::class,
        DashboardProductRoutes::class,
        DashboardBlogRoutes::class,
        SlideRoutes::class,
        SettingsRoutes::class,
        CommentRoutes::class,
        ImageRoutes::class,
        DashboardPageRoutes::class,
        DashboardRecipeRoutes::class,
    ]);
});

//Public Routes
Route::group(['prefix' => $localePrefix], function () {
    Organizer::register([
        RootRoutes::class,
        CategoryRoutes::class,
        ProductRoutes::class,
        BlogRoutes::class,
    ]);
    require __DIR__.'/auth.php';
    Route::get('{page:slug}', \App\Http\Controllers\PageController::class)->name('page');
});
Route::get('media/{image:token}', MediaController::class)->name('media');



