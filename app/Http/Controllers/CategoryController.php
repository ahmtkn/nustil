<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = cache()->remember('category_index_'.app()->getLocale(), 86400, function () {
            return Category::withCount('products')
                ->with('children')
                ->locale(app()->getLocale())
                ->onlyParents()
                ->orderByDesc('products_count')
                ->get();
        });
        $products = cache()->remember('all_products'.app()->getLocale(), 86400, function () {
            return Product::with('image')
                ->orderByDesc('id')
                ->get();
        });

        return view('category.index', compact('categories', 'products'));
    }

    public function show(Category $category)
    {
//        if ($category->locale != app()->getLocale()) {
//            return abort(404);
//        }
        $category = cache()->remember(
            'category_'.$category.'_single'.app()->getLocale(),
            86400,
            fn() => $category->load('products.image', 'descendants', 'children')
        );

        return view('category.show', compact('category'));
    }

}
