<?php


return [

    'sitemaps' => ['default', 'blog', 'product'],

    'default' => [
        [
            'name' => 'landing',
            'model' => null,
        ],
        [
            'name' => 'page',
            'model' => \App\Models\Page::class,
        ],
        [
            'name' => 'category.index',
            'model' => null,
        ],
        [
            'name' => 'blog.index',
            'model' => null,
        ],
    ],
    'category' => [
        [
            'name' => 'category.index',
            'model' => null,
        ],
        [
            'name' => 'category.show',
            'model' => \App\Models\Category::class,
        ],
    ],
    'product' => [
        [
            'name' => 'product.show',
            'model' => \App\Models\Product::class,
        ],

    ],
    'blog' => [
        [
            'name' => 'blog.index',
            'model' => null,
        ],
        [
            'name' => 'blog.category',
            'model' => \App\Models\BlogCategory::class,
            'model_alias' => 'category',
        ],
        [
            'name' => 'blog.post',
            'model' => \App\Models\BlogPost::class,
            'model_alias' => 'post',
            'load' => ['categories'],
        ],
    ],


];
