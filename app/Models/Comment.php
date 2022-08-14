<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $fillable = [
        'name',
        'email',
        'body',
    ];

    protected $casts = [
        'approved' => 'boolean',
    ];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function scopePending(Builder $builder)
    {
        return $builder->where('approved', false);
    }

    public function scopeApproved(Builder $builder)
    {
        return $builder->where('approved', true);
    }

    public function approve()
    {
        $this->approved = true;
        $this->save();
    }

    public function reject()
    {
        $this->delete();
    }

}
