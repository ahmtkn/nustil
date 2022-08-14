<?php

namespace App\Routes;

use App\Models\BlogPost;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use Uutkukorkmaz\RouteOrganizer\Contracts\RouteContract;

class BlogRoutes implements RouteContract
{

    public static function register(): void
    {
        Route::group(['prefix' => 'blog', 'as' => 'blog.'], function () {
            Route::get('/', [BlogController::class, 'index'])->name('index');
            Route::get('{category:slug}/{post:slug}', [BlogController::class, 'post'])->name('post');
            Route::get('{category:slug}', [BlogController::class, 'category'])->name('category');
        });

        Route::bind('post', function ($slug) {
            return BlogPost::where('slug', $slug)->first() ?? abort(404);
        });
    }

}
