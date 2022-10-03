<?php

namespace App\Http\Controllers;

use App\Models\Redirect;
use Illuminate\Http\Request;

class RedirectController extends Controller
{

    public function __invoke(Request $request)
    {
        $requested = trim($request->getRequestUri(), '/');

        $redirect = Redirect::deprecated($requested)->firstOrFail();

        return redirect($redirect->current, $redirect->status);
    }

}
