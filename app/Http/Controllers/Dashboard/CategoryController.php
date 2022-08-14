<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::with('descendants')
            ->onlyParents()
            ->latest()
            ->paginate(10);


        return view('dashboard.categories.index', compact('categories'));
    }

    public function edit(Category $category)
    {
        return view('dashboard.categories.editor', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $category->update($request->all());


        return redirect()->route('dashboard.categories.index')->with('message', 'Category updated successfully');
    }

    public function create()
    {
        return view('dashboard.categories.editor', ['category' => new Category()]);
    }

    public function store(Request $request)
    {
        Category::create($request->all() + ['slug' => Str::slug($request->name)]);

        return redirect()->route('dashboard.categories.index')->with('message', 'Category created successfully');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('dashboard.categories.index')->with('message', 'Category deleted successfully');
    }


}
