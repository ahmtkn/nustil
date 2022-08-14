<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class SitemapItem
{

    protected ?string $defaultTime = null;

    public ?string $priority = '1.0';

    public Carbon $updated_at;

    public string $url;

    public string $frequency;

    protected ?Model $model = null;

    public function __construct(
        string $routeName,
        ?string $priority = null,
        ?Model $model = null,
        string $frequency = 'weekly'
    ) {
        $this->defaultTime = $this->defaultTime ?? now();
        $this->model = $model;
        $this->url = $this->getUrl($routeName);
        $this->priority = $priority;
        $this->frequency = $frequency;
        $this->updated_at = is_null($model)
            ? Carbon::createFromTimestamp(strtotime($this->defaultTime))
            : $model->updated_at;
    }

    protected function getUrl($name)
    {
        if (is_null($this->model)) {
            return route($name);
        }
        $modelName = explode('\\', get_class($this->model));

        return route($name, [Str::lower(end($modelName)) => $this->model]);
    }

}
