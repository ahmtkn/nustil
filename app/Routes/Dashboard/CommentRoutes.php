<?php

namespace App\Routes\Dashboard;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\CommentController;


class CommentRoutes implements \Uutkukorkmaz\RouteOrganizer\RegistersRouteGroup
{

    public static function register(): void
    {
        Route::group(['prefix' => 'comments', 'as' => 'comments.'], function () {
            Route::get('/', [CommentController::class, 'index'])
                ->name('index');

            Route::group(['prefix' => '{comment}'], function () {
                Route::delete('/', [CommentController::class, 'destroy'])
                    ->name('delete');
                Route::patch('/', [CommentController::class, 'approve'])
                    ->name('approve');
            });
        });
    }

}
