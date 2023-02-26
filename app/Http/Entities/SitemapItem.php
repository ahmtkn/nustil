<?php

namespace App\Http\Entities;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Routing\Route;
use Illuminate\Support\Collection;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Model;

class SitemapItem
{

    protected const DEFAULT_TIME = '2022-03-03 12:53:00';

    public ?string $priority = '1.0';

    public Carbon $updated_at;

    public string $url;

    public string $frequency;

    protected ?Model $model = null;

    public function __construct(
        string $routeName,
        ?string $priority = null,
        ?Model $model = null,
        ?array $params = null,
        string $frequency = 'weekly'
    ) {
        $this->model = $model;
        $this->url = $this->getUrl($routeName, $params);
        $this->priority = $priority;
        $this->frequency = $frequency;
        $this->updated_at = is_null($model)
            ? Carbon::createFromTimestamp(strtotime(self::DEFAULT_TIME))
            : $model->updated_at;
    }

    protected function getUrl($name, $params)
    {
        if (is_null($this->model)) {
            return route($name);
        }

        return route($name, $params);
    }

}
