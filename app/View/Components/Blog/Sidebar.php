<?php

namespace App\View\Components\Blog;

use App\Models\BlogPost;
use App\Models\BlogCategory;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Sidebar extends Component
{

    public $posts;

    public $categories;

    public $popularPosts;

    public function __construct()
    {
        $this->posts = cache()->remember(
            'all_posts_'.app()->getLocale(), 86400,
            fn() => BlogPost::with('categories', 'image')
                ->withCount('view')
                ->locale(app()->getLocale())
                ->published()
                ->orderByDesc('published_at')
                ->get()
        );
        $this->categories = cache()->remember(
            'all_categories_'.app()->getLocale(), 86400,
            fn() => BlogCategory::withCount('posts')->onlyParents()->locale(app()->getLocale())->get()
                ->sortByDesc('posts_count')
        );
        $this->popularPosts = cache()->remember(
            'popular_posts_'.app()->getLocale(), 86400,
            fn() => BlogPost::with('categories', 'image')
                ->withCount('view')
                ->published()
                ->locale(app()->getLocale())
                ->get()
                ->sortByDesc('view_count')
                ->take(5)
        );
    }

    public function render(): View
    {
        return view('components.blog.sidebar');
    }

}
