<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasChildren
{

    /**
     * The relation that has many children.
     *
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * The relation that belongs to a parent.
     *
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * The relation that has many descendants.
     *
     * @return HasMany
     */
    public function descendants()
    {
        return $this->children()->with('descendants');
    }

    /**
     * The relation that has many ancestors.
     *
     * @return BelongsTo
     */
    public function ancestors(): BelongsTo
    {
        return $this->parent()->with('ancestors');
    }

    /**
     * Scope for the parent categories only.
     *
     * @param  Builder  $builder
     *
     * @return Builder
     */
    public function scopeOnlyParents(Builder $builder): Builder
    {
        return $builder->whereNull('parent_id');
    }

}
