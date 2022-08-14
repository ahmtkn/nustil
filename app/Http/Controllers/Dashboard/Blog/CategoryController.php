<?php

namespace App\Http\Controllers\Dashboard\Blog;

use Illuminate\Support\Str;
use App\Models\BlogCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = BlogCategory::with('descendants')
            ->onlyParents()
            ->latest()
            ->paginate(10);

        return view('dashboard.blog.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('dashboard.blog.categories.editor', ['category' => new BlogCategory()]);
    }

    public function store(Request $request)
    {
        BlogCategory::create($request->all() + ['slug' => Str::slug($request->name)]);

        return redirect()->route('dashboard.blog.categories.index')
            ->with('message', 'Category created successfully');
    }

    public function edit(BlogCategory $category)
    {
        $category->load('ancestors');

        return view('dashboard.blog.categories.editor', compact('category'));
    }

    public function update(Request $request, BlogCategory $category)
    {
        $category->update($request->all());

        return redirect()->route('dashboard.blog.categories.index')
            ->with('message', 'Category updated successfully');
    }

    public function delete(BlogCategory $category)
    {
        $category->delete();

        return redirect()->route('dashboard.blog.categories.index')->with('message', 'Category deleted successfully');
    }

}
