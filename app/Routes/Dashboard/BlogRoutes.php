<?php

namespace App\Routes\Dashboard;

use App\Models\BlogPost;
use App\Models\BlogCategory;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\Blog\PostController;
use Uutkukorkmaz\RouteOrganizer\Contracts\RouteContract;
use App\Http\Controllers\Dashboard\Blog\CategoryController;

class BlogRoutes implements RouteContract
{

    public static function register(): void
    {
        Route::group(['prefix' => 'blog', 'as' => 'blog.'], function () {
            Route::group(['prefix' => 'categories', 'as' => 'categories.'], function () {
                Route::get('/', [CategoryController::class, 'index'])
                    ->middleware('can:categories.read')
                    ->name('index');

                Route::get('/create', [CategoryController::class, 'create'])
                    ->middleware('can:categories.create')
                    ->name('create');

                Route::post('/store', [CategoryController::class, 'store'])
                    ->middleware('can:categories.create')
                    ->name('store');

                Route::group(['prefix' => '{category}'], function () {
                    Route::get('/edit', [CategoryController::class, 'edit'])
                        ->middleware('can:categories.update')
                        ->name('edit');

                    Route::put('/update', [CategoryController::class, 'update'])
                        ->middleware('can:categories.update')
                        ->name('update');

                    Route::delete('/delete', [CategoryController::class, 'delete'])
                        ->middleware('can:categories.delete')
                        ->name('delete');
                });
            });

            Route::group(['prefix' => 'posts', 'as' => 'posts.'], function () {

                Route::get('create', [PostController::class, 'create'])
                    ->middleware('can:blogs.create')
                    ->name('create');

                Route::post('store', [PostController::class, 'store'])
                    ->middleware('can:blogs.create')
                    ->name('store');

                Route::group(['prefix' => '{post}'], function () {
                    Route::get('edit', [PostController::class, 'edit'])
                        ->middleware('can:blogs.update')
                        ->name('edit');

                    Route::put('update', [PostController::class, 'update'])
                        ->middleware('can:blogs.update')
                        ->name('update');

                    Route::delete('delete', [PostController::class, 'delete'])
                        ->middleware('can:blogs.delete')
                        ->name('delete');
                });

                Route::get('/{filter?}', [PostController::class, 'filtered'])
                    ->middleware('can:blogs.read')
                    ->name('index');
            });
        });

        Route::bind('post', function ($id) {
            return BlogPost::withTrashed()->findOrFail($id);
        });
    }

}
