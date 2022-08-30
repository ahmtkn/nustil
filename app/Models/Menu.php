<?php

namespace App\Models;

use Spatie\Menu\Laravel\Link;
use App\Traits\HasLocalizedItems;
use App\Models\Scopes\MenuOrderScope;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{

    use HasFactory, HasLocalizedItems;

    protected $fillable = [
        'method',
        'to',
        'title',
        'group',
        'payload',
        'order',
        'locale',
    ];

    protected $casts = [
        'payload' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new MenuOrderScope);
    }

    public function scopeGroup(Builder $builder, null|string $group = null)
    {
        return $builder->where('group', $group);
    }

    public static function getGroups()
    {
        return self::orderBy('order')->pluck('group')->unique();
    }

    public static function prepare($group = null)
    {
        $locale = app()->getLocale();
        $items = cache()->remember(
            'menu-'.$group.'-'.$locale,
            86400,
            fn() => self::group($group)->locale(app()->getLocale())->get()
        );
        $menu = \Spatie\Menu\Laravel\Menu::new();
        foreach ($items as $item) {
            $itemType = self::getAnchorTag($item);
            if (!is_null($itemType)) {
                $menu->add($itemType->addParentClass('lg:animate-x'));
            }
        }
        $menu->addClass($group.'-navigation')->setActiveFromRequest();

        return $menu;
    }

    public static function getAnchorTag($item)
    {
        switch ($item->method) {
            default:
            case 'url':
                return Link::toUrl($item->to, $item->title, $item->payload);
            case 'route':
                return Route::has($item->to) ? Link::toRoute($item->to, $item->title, $item->payload) : null;
            case 'action':
                return Link::toAction($item->to, $item->title, $item->payload);
        }
    }

    public static function getURL($item)
    {
        switch ($item->method) {
            default:
            case 'url':
                return $item->to;
            case 'route':
                return Route::has($item->to) ? route($item->to, $item->payload) : null;
        }
    }

    public function moveUp()
    {
        $this->update(['order' => $this->order - 1]);

        return $this;
    }

    public function moveDown()
    {
        $this->update(['order' => $this->order + 1]);

        return $this;
    }

    public function moveToPosition(int $position)
    {
        $this->update(['order' => $position]);

        return $this;
    }

}
