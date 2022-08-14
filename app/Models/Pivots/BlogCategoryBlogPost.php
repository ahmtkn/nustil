<?php

namespace App\Models\Pivots;

use App\Models\BlogPost;
use App\Models\BlogCategory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BlogCategoryBlogPost extends Pivot
{
    use HasFactory;

    protected $table = 'blog_category_blog_post';

    public $timestamps = false;

    public function category()
    {
        return $this->belongsTo(BlogCategory::class);
    }

    public function post()
    {
        return $this->belongsTo(BlogPost::class);
    }
}
