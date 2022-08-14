<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{

    protected $fillable = [
        'name',
        'path',
        'mime_type',
        'type',
    ];

    protected $appends = [
        'url',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($image) {
            $image->token = Str::upper(Str::uuid());
        });
    }

    /**
     * Get the imageable model.
     *
     * @return MorphTo
     */
    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }


    public function url(): Attribute
    {
        return Attribute::make(get: fn() => route('media', $this));
    }

    public function delete()
    {
        $this->deleteFile();
        parent::delete();
    }

    public function deleteFile()
    {
        $file = storage_path('app/'.$this->path);
        if (file_exists($file)) {
            unlink($file);
        }
    }

}
