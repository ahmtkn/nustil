<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;

use App\Models\BlogCategory;

class BlogController extends Controller
{

    public function index()
    {
        $data = [
            'posts' => cache()->remember(
                'all_posts_'.app()->getLocale(), 86400,
                fn() => BlogPost::with('categories', 'image')
                    ->withCount('view')
                    ->locale(app()->getLocale())
                    ->published()
                    ->orderByDesc('published_at')
                    ->get()
            ),
            'categories' => cache()->remember(
                'all_categories_'.app()->getLocale(), 86400,
                fn() => BlogCategory::withCount('posts')->onlyParents()->locale(app()->getLocale())->get()
                    ->sortByDesc('posts_count')
            ),
            'popularPosts' => cache()->remember(
                'popular_posts_'.app()->getLocale(), 86400,
                fn() => BlogPost::with('categories', 'image')
                    ->withCount('view')
                    ->published()
                    ->locale(app()->getLocale())
                    ->get()
                    ->sortByDesc('view_count')
                    ->take(5)
            ),
        ];

        return view('blog.index', $data);
    }

    public function category(BlogCategory $category)
    {
        $category = cache()->remember(
            'blog_category_'.$category->id,
            86400,
            fn() => $category->load(['posts.image', 'posts.categories', 'children'])
        );

        return view('blog.category', compact('category'));
    }

    public function post(BlogCategory $category, BlogPost $post)
    {
        $post->addView();
        cache()->flush();
        $post->load('image', 'categories');


        return view('blog.post', compact('post'));
    }

}
