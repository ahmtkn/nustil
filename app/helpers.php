<?php

if (!function_exists('getLocales')) {
    function getLocales()
    {
        $striped = array_diff(scandir(base_path('resources/lang')), ['..', '.']);
        $output = [];
        foreach ($striped as $lang) {
            if (is_dir(base_path('resources/lang/'.$lang))) {
                $output[$lang] = __($lang);
            }
        }

        return $output;
    }
}
if (!function_exists('array_notation')) {
    function array_notation($items, $parse = false)
    {
        return new \App\Helpers\ArrayNotationHelper($items, $parse);
    }
}
if (!function_exists('number_shorten')) {
    function number_shorten($number, $precision = 3, $divisors = null)
    {
        // Setup default $divisors if not provided
        if (!isset($divisors)) {
            $divisors = [
                pow(1000, 0) => '', // 1000^0 == 1
                pow(1000, 1) => 'K', // Thousand
                pow(1000, 2) => 'M', // Million
                pow(1000, 3) => 'B', // Billion
                pow(1000, 4) => 'T', // Trillion
                pow(1000, 5) => 'Qa', // Quadrillion
                pow(1000, 6) => 'Qi', // Quintillion
            ];
        }

        // Loop through each $divisor and find the
        // lowest amount that matches
        foreach ($divisors as $divisor => $shorthand) {
            if (abs($number) < ($divisor * 1000)) {
                // We found a match!
                break;
            }
        }

        // We found our match, or there were no matches.
        // Either way, use the last defined value for $divisor.
        return number_format($number / $divisor, $precision).$shorthand;
    }
}
if (!function_exists('array_filter_recursive')) {
    function array_filter_recursive(array $array, Closure $callback = null)
    {
        foreach ($array as &$value) {
            if (is_array($value)) {
                $value = array_filter_recursive($value, $callback);
            }
        }

        return array_filter($array, $callback);
    }
}

if (!function_exists('hex2rgb')) {
    function hex2rgb($hex)
    {
        $hex = str_replace('#', '', $hex);
        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1).substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1).substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1).substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        $rgb = [$r, $g, $b];

        return $rgb;
    }
}

if (!function_exists('rgba')) {
    function rgba($hex, $alpha = 1)
    {
        return 'rgba('.implode(',', hex2rgb($hex)).','.$alpha.')';
    }
}

if (!function_exists('contrast')) {
    function contrast($hex = '#000000')
    {
        $R1 = hexdec(substr($hex, 1, 2));
        $G1 = hexdec(substr($hex, 3, 2));
        $B1 = hexdec(substr($hex, 5, 2));

        $blackColor = "#000000";
        $R2BlackColor = hexdec(substr($blackColor, 1, 2));
        $G2BlackColor = hexdec(substr($blackColor, 3, 2));
        $B2BlackColor = hexdec(substr($blackColor, 5, 2));


        $L1 = 0.2126 * pow($R1 / 255, 2.2) +
            0.7152 * pow($G1 / 255, 2.2) +
            0.0722 * pow($B1 / 255, 2.2);

        $L2 = 0.2126 * pow($R2BlackColor / 255, 2.2) +
            0.7152 * pow($G2BlackColor / 255, 2.2) +
            0.0722 * pow($B2BlackColor / 255, 2.2);

        $contrastRatio = 0;
        if ($L1 > $L2) {
            $contrastRatio = (int)(($L1 + 0.05) / ($L2 + 0.05));
        } else {
            $contrastRatio = (int)(($L2 + 0.05) / ($L1 + 0.05));
        }
        if ($contrastRatio > 5) {
            return '#000000';
        } else {
            return '#FFFFFF';
        }
    }
}


function drupal_array_merge_deep() {
    $args = func_get_args();
    return drupal_array_merge_deep_array($args);
}

// source : https://api.drupal.org/api/drupal/includes%21bootstrap.inc/function/drupal_array_merge_deep_array/7.x
function drupal_array_merge_deep_array($arrays) {
    $result = array();
    foreach ($arrays as $array) {
        foreach ($array as $key => $value) {
            // Renumber integer keys as array_merge_recursive() does. Note that PHP
            // automatically converts array keys that are integer strings (e.g., '1')
            // to integers.
            if (is_integer($key)) {
                $result[] = $value;
            }
            elseif (isset($result[$key]) && is_array($result[$key]) && is_array($value)) {
                $result[$key] = drupal_array_merge_deep_array(array(
                    $result[$key],
                    $value,
                ));
            }
            else {
                $result[$key] = $value;
            }
        }
    }
    return $result;
}
