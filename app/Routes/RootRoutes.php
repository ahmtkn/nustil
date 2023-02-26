<?php

namespace App\Routes;

use App\Models\Contact;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\ContactFormRequest;
use App\Http\Controllers\LandingController;


class RootRoutes implements \Uutkukorkmaz\RouteOrganizer\RegistersRouteGroup
{

    public static function register(): void
    {
        Route::get('/', LandingController::class)->name('landing');

//        Route::view(__('route.contact'), 'contact')->name('contact');
//        Route::post('contact', function(ContactFormRequest $request){
//            Contact::create($request->validated());
//            return redirect()->route('contact')->with('success', __('contact.success'));
//        })->name('contact.store');
    }

}
