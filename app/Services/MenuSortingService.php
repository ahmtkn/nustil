<?php

namespace App\Services;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Collection;

class MenuSortingService
{

    public $items;

    public string $group;

    public ?string $locale = null;

    public function __construct(string $group, ?string $locale = null)
    {
        $this->locale = $locale;
        $this->group = $group;
        $this->locale = $locale ?? app()->getLocale();
        $this->items = Menu::group($this->group)->locale($this->locale)->get();
    }

    public function save()
    {
        $this->items->each(function ($item, $index) {
            if (get_debug_type($item) == Menu::class) {
                $item->update(['order' => $index]);
            }
        });

        return $this->items;
    }

    public function direction(string $direction)
    {
        switch ($direction) {
            case 'top':
                return 'moveToTop';
            default:
            case 'bottom':
                return 'moveToBottom';
            case 'up':
                return 'moveUp';
            case 'down':
                return 'moveDown';
        }
    }

    protected function move(int $from, int $to)
    {
        $item = $this->items->get($from);
        $this->items->pull($from);
        $this->items->splice($to, 0, collect([$item]));

        return $this->save();
    }

    public function moveUp(Menu $menu)
    {
        $index = $this->items->search($menu);
        if ($index > 0) {
            return $this->move($index, $index - 1);
        }

        return $this->items;
    }

    public function moveDown(Menu $menu)
    {
        $index = $this->items->search($menu);
        if ($index < $this->items->count() - 1) {
            return $this->move($index, $index + 1);
        }

        return $this->items;
    }

    public function moveToTop(Menu $menu)
    {
        $index = $this->items->search($menu);
        if ($index > 0) {
            return $this->move($index, 0);
        }

        return $this->items;
    }

    public function moveToBottom(Menu $menu)
    {
        $index = $this->items->search($menu);
        if ($index < $this->items->count() - 1) {
            return $this->move($index, $this->items->count() - 1);
        }

        return $this->items;
    }


}
