<?php

namespace App\Models;

use App\Traits\Viewable;
use App\Traits\Publishable;
use App\Traits\HasLocalizedItems;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{

    use Viewable;
    use HasFactory;
    use SoftDeletes;
    use Publishable;
    use HasLocalizedItems;

    protected $fillable = [
        'locale',
        'title',
        'slug',
        'content',
        'status',
        'options',
    ];

    protected $casts = [
        'options' => 'array',
    ];

    public $defaultOptions = [
        'display_page_title' => false,
        'display_breadcrumbs' => false,
        'display_last_modified_date' => false,
        'fullwidth' => false,
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($page) {
            $page->options = array_merge($page->defaultOptions, $page->options);
        });
        static::updating(function ($page) {
            $page->options = array_merge($page->defaultOptions, $page->options);
            cache()->flush();
        });
    }

    public function getOptionsAttribute($value)
    {
        return array_merge($this->defaultOptions, json_decode($value ?? '{}', true));
    }


}
