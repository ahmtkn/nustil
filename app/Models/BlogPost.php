<?php

namespace App\Models;

use Carbon\Carbon;
use App\Traits\Viewable;
use App\Traits\Imageable;
use App\Traits\Commentable;
use App\Traits\Publishable;
use Illuminate\Support\Str;
use App\Traits\HasLocalizedItems;
use App\Models\Scopes\CurrentLocaleScope;
use App\Models\Pivots\BlogCategoryBlogPost;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{

    use HasFactory, SoftDeletes, Commentable, Publishable, HasLocalizedItems, Viewable, Imageable;

    protected $fillable = [
        'title',
        'slug',
        'body',
        'tags',
        'locale',
        'status',
        'published_at',
    ];

    protected $appends = [
        "read_time",
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CurrentLocaleScope());
    }

    /**
     * Get the categories of the post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(BlogCategory::class)
            ->using(BlogCategoryBlogPost::class);
    }

    public function readTime(): Attribute
    {
        return new Attribute(get: function () {
            return $this->body ? ceil(str_word_count($this->body) / 200) : 0;
        });
    }

    public function publishTimeDiff()
    {
        if (!$this->published_at) {
            return "";
        }
        $diffInDays = $this->published_at->diffInDays();

        if ($diffInDays < 1) {
            return $this->published_at->diffForHumans();
        }
        $format = 'd M';

        if ($diffInDays > 30) {
            $format = 'M Y';
        }

        return $this->published_at->translatedFormat($format);
    }

}
