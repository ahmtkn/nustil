<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{

    public function __invoke(Page $page)
    {
        $page->addView();

        return view('page', compact('page'));
    }

}
