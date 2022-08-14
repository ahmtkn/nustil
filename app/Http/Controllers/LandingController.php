<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Settings\GeneralSettings;

class LandingController extends Controller
{

    public function __invoke(GeneralSettings $settings)
    {
        $latestProducts = cache()->remember('latest_products_'.app()->getLocale(), 86400, function () use ($settings) {
            return Product::with('image',)
                ->orderByDesc('id')
                ->limit($settings->home['latestProductsCount'])
                ->get();
        });

        return view('landing', compact('latestProducts'));
    }


}
