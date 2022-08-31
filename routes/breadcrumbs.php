<?php

use App\Models\Page;
use App\Models\Recipe;
use App\Models\Product;
use App\Models\Category;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as Trail;


Breadcrumbs::for('landing', function (Trail $trail) {
    $trail->push(__('Home'), route('landing'));
});

Breadcrumbs::for('blog', function (Trail $trail) {
    $trail->parent('landing');
    $trail->push(__('Blog'), route('blog.index'));
});

Breadcrumbs::for(__('route.category'), function (Trail $trail, Category $category) {
    if (!$category->relationLoaded('ancestors')) {
        $category = cache()->remember(
            'category_'.$category->id.'_ancestors',
            86400,
            fn() => $category->load('ancestors')
        );
    }
    $trail->parent('landing');
    $trail->push(__('Categories'), route('category.index'));
    if ($category->ancestors) {
        addCategoryAncestor($trail, $category);
    }

    $trail->push($category->name, route('category.show', $category));
});

Breadcrumbs::for('recipes', function (Trail $trail, Recipe $recipe) {
    $trail->parent('landing');
    $trail->push(__('Products'), route('category.index'));
;
    $product = $recipe->products->where('slug', request()->segment(3))->first();
    $trail->push(Str::limit($product->name,20), route('product.show', $product));
    $trail->push($recipe->name, route('product.recipe.show', ['product' => $product, "recipe" => $recipe]));
}
);

Breadcrumbs::for('page', function (Trail $trail, Page $page) {
    $trail->parent('landing');
    $trail->push($page->title, route('page', $page));
});

Breadcrumbs::for('post', function (Trail $trail, BlogPost $post) {
    if (!$post->relationLoaded('categories')) {
        $post->load('categories');
    }
    $category = $post->categories->first();
    $trail->parent('landing');
    $trail->push(__('Blog'), route('blog.index'));
    $trail->push($category->name, route('blog.category', $category));
    $trail->push($post->title, route('blog.post', ['category' => $post->categories->first(), 'post' => $post]));
});

Breadcrumbs::for('blog.category', function (Trail $trail, BlogCategory $category) {
    if (!$category->relationLoaded('ancestors')) {
        $category = cache()->remember(
            'blog_category_'.$category->id.'_ancestors',
            86400,
            fn() => $category->load('ancestors')
        );
    }
    $trail->parent('blog');

    if ($category->ancestors) {
        addCategoryAncestor($trail, $category, 'blog.category');
    }

    $trail->push($category->name, route('blog.category', $category));
});

function addCategoryAncestor($trail, $category, $route = 'category.show')
{
    if (!$category->relationLoaded('ancestors')) {
        $category = cache()->remember(
            'category_'.$category->id.'_ancestors',
            86400,
            fn() => $category->load('ancestors')
        );
    }

    if ($ancestor = $category->ancestors) {
        $trail->push($ancestor->name, route($route, $ancestor));
        if ($ancestor->ancestors) {
            addCategoryAncestor($trail, $ancestor);
        }
    }
}
