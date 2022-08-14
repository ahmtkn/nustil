<?php

namespace App\Observers;

use App\Models\Category;

class CategoryObserver
{

    /**
     * Handle the Category "created" event.
     *
     * @param  \App\Models\Category  $category
     *
     * @return void
     */
    public function created(Category $category)
    {

        cache()->flush();
    }

    /**
     * Handle the Category "updated" event.
     *
     * @param  \App\Models\Category  $category
     *
     * @return void
     */
    public function updated(Category $category)
    {
        $this->loadRelations($category);
        $this->updateChildrenRecursive($category, ['locale' => $category->locale]);

        cache()->flush();
    }

    /**
     * Handle the Category "deleted" event.
     *
     * @param  \App\Models\Category  $category
     *
     * @return void
     */
    public function deleted(Category $category)
    {

        cache()->flush();
    }

    /**
     * Handle the Category "restored" event.
     *
     * @param  \App\Models\Category  $category
     *
     * @return void
     */
    public function restored(Category $category)
    {
        //
    }

    /**
     * Handle the Category "force deleted" event.
     *
     * @param  \App\Models\Category  $category
     *
     * @return void
     */
    public function forceDeleted(Category $category)
    {
        //
    }

    protected function loadRelations(Category $category)
    {
        if (!$category->relationLoaded('descendants')) {
            $category->load('descendants');
        }
    }

    protected function updateChildrenRecursive(Category $category, array $data)
    {
        $category->children->each(function (Category $child) use ($category, $data) {
            $child->update($data);
            $this->updateChildrenRecursive($child, $data);
        });
    }

}
