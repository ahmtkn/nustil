<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Model;

class View extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'ip',
        'user_agent',
        'referer',
        'viewed_at',
    ];

    public function viewable(): MorphTo
    {
        return $this->morphTo();
    }


}
