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

    public function list()
    {
        return view('dashboard.redirects.list', [
            'redirects' => Redirect::orderByDesc('id')->paginate(15),
        ]);
    }

    public function redirect(Request $request)
    {
        $validated = $request->validate([
            'deprecated' => 'required',
            'current' => 'required',
            'status' => 'required',
        ]);

        $request->merge([
            'deprecated' => rtrim(ltrim($request->deprecated,'/'), '/'),
        ]);

        Redirect::create($validated);

        return redirect()->route('dashboard.redirects')->with('message', 'Redirect created successfully');
    }

    public function delete(Redirect $redirect)
    {
        $redirect->delete();

        return redirect()->route('dashboard.redirects')->with('message', 'Redirect deleted successfully');
    }

}
