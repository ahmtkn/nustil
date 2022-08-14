<?php

namespace App\Helpers;

class LocalizationHelper {

    public static function prefix(string $segment) {
        if ($segment && in_array($segment, array_keys(getLocales()))) {
            app()->setLocale($segment);

            return $segment;
        }
        app()->setLocale(config('app.locale'));

        return config('app.locale');
    }

}
