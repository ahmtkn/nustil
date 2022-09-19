<?php

namespace App\Models;

use App\Traits\Viewable;
use App\Traits\Imageable;
use App\Traits\Commentable;
use App\Traits\Publishable;
use App\Traits\HasLocalizedItems;
use App\Models\Scopes\CurrentLocaleScope;
use App\Models\Pivots\BlogCategoryBlogPost;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BlogPost extends Model
{

    use Viewable;
    use Imageable;
    use HasFactory;
    use Publishable;
    use SoftDeletes;
    use Commentable;
    use HasLocalizedItems;

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
     * @return BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(BlogCategory::class)
            ->using(BlogCategoryBlogPost::class);
    }

    public function getReadTimeAttribute()
    {
        return $this->body ? ceil(str_word_count($this->body) / 200) : 0;
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
