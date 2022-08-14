<?php

namespace App\Models;

use App\Traits\HasChildren;
use App\Traits\HasLocalizedItems;
use App\Models\Pivots\BlogCategoryBlogPost;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{

    use HasFactory, HasLocalizedItems, HasChildren;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'locale',
        'parent_id',
    ];

    public function posts()
    {
        return $this->belongsToMany(BlogPost::class)
            ->using(BlogCategoryBlogPost::class)
            ->with('image')
            ->withCount('view')
            ->latest('published_at');
    }


}
