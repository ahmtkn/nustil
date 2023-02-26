<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Entities\SitemapItem;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class SitemapController extends Controller
{

    const DEFAULT_DATE = '2022-03-03 12:50:22';

    public function sitemaps()
    {
        $data = cache()->remember('sitemaps', 86400 * 7, function () {
            $toCache = [];
            $sitemaps = config('sitemap.sitemaps');
            foreach (getLocales() as $locale => $language) {
                foreach ($sitemaps as $sitemap) {
                    $toCache[] = (object)[
                        'url' => url($locale.'/'.($sitemap == 'default' ? '' : $sitemap.'-').'sitemap.xml'),
                        'updated_at' => Carbon::now(),
                        'frequency' => 'weekly',
                        'priority' => null,
                    ];
                }
            }

            return $toCache;
        });

        return response()->view('sitemap.index', compact('data'))
            ->header('Content-Type', 'text/xml');
    }

    public function index()
    {
        $data = cache()->remember(
            'sitemap-'.$locale = app()->getLocale(),
            86400,
            fn() => $this->prepareSitemapData('default', $locale)
        );

        return response()->view('sitemap.index', compact('data'))
            ->header('Content-Type', 'text/xml');
    }

    protected function getRoutes(string $group = 'default')
    {
        return config("sitemap.{$group}");
    }

    public function custom(string $type = "default")
    {
        $locale = app()->getLocale();

        if (!array_key_exists($type, config('sitemap'))) {
            abort(404);
        }

        $cacheKey = "sitemap.{$locale}.{$type}";

        $data = cache()->remember($cacheKey, 86400 * 7, fn() => $this->prepareSitemapData($type));


        return response()->view('sitemap.index', compact('data'))
            ->header('Content-Type', 'text/xml');
    }

    protected function prepareSitemapData($config = 'default', $locale = null)
    {
        if (!is_null($locale)) {
            app()->setLocale($locale);
        }
        $out = collect([]);
        $defaultTime = Carbon::createFromTimestamp(strtotime(self::DEFAULT_DATE));
        foreach ($this->getRoutes($config) as $route) {
            if (!is_null($route['model'])) {
                $items = app($route['model']);

                if (method_exists($items, 'locale')) {
                    $items = $items->locale(app()->getLocale());
                }
                foreach ($items->orderBy('created_at')->get() as $item) {
                    $model = $route['model_alias'] ?? Str::of($route['model'])->afterLast('\\')->lower()->__toString();
                    $params = [
                        $model => $item,
                    ];
                    if (array_key_exists('load', $route)) {
                        $item->load($route['load']);
                    }

                    foreach ($route['load'] ?? [] as $relation) {
                        $params[Str::singular($relation)] = $item->{$relation}->first();
                    }

                    $out->add($this->prepareSitemapItem($route, $item, $params));
                }
            } else {
                $out->add($this->prepareSitemapItem($route));
            }
        }

        return $out;
    }

    protected function prepareSitemapItem(array $configEntry, ?Model $model = null, $params = [])
    {
        return new SitemapItem($configEntry['name'], $model ? '1.0' : null, $model, $params);
    }

}
