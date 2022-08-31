<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function __invoke(Product $product)
    {
        $product = cache()->remember(
            'product_'.$product->id,
            86400,
            fn() => $product->load('image', 'nutritions', 'ingredients', 'categories', 'recipes.image')
        );

        $product->addView();

        return view('product', compact('product'));
    }

    public function recipe(Product $product, Recipe $recipe)
    {
        $recipe = cache()->remember(
            'recipe_'.$recipe->id,
            86400,
            fn() => $recipe->load('image', 'products.image')
        );

        $recipe->addView();

        return view('recipe', compact('product', 'recipe'));
    }

}
