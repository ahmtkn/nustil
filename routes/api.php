<?php

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Response as ResponseStatus;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'newsletter', 'as' => 'newsletter.'], function () {
    Route::post('subscribe', [\App\Http\Controllers\NewsletterController::class, 'subscribe'])->name('subscribe');
});

Route::post('route', function (Request $request) {
    $output = [];
    $name = $request->input('route');
    $route = Route::getRoutes()->getByName($name);
    if (!$route) {
        return response()->json(['error' => 'Route not found'], ResponseStatus::HTTP_NOT_FOUND);
    }

    if (!preg_match('/\{(.*)\}/', $route->uri, $params)) {
        return response()->json(['error' => 'Route has no parameters'], ResponseStatus::HTTP_IM_USED);
    }

    $params = array_filter($params, fn($param) => !str_contains($param, '{') && !str_contains($param, '}'));

    foreach ($params as $param) {
        $model = Str::studly($param);
        if (!file_exists(app_path('Models/'.$model.'.php'))) {
            return response()->json(['error' => 'Model not found'], ResponseStatus::HTTP_NOT_FOUND);
        }
        $model = 'App\Models\\'.$model;
        /**
         * @var Model $model
         */

        $ref = new ReflectionClass($model);

        $output[$param] = in_array(
            'App\Traits\HasLocalizedItems',
            $ref->getTraitNames()
        )
            ? $model::locale($request->input('locale') ?? app()->getLocale())->get()
            : $model::all();
    }
    if (array_diff($output, [])) {
        return response()->json($output);
    }

    return response()->json(['error' => 'Model has no content'], ResponseStatus::HTTP_PARTIAL_CONTENT);
})->name('route.show');
