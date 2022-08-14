<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{

    public string $site_name;

    public string $phone_number;

    public string $address;

    public string $contact_email;

    public array $social_media;

    public array $ecommerce;

    public array $product;

    public array $home;

    public array $newsletter;

    public array $blog;

    public static function group(): string
    {
        return 'general';
    }

    public function reset()
    {
        foreach (config('nustil.settings') as $prop => $value) {
            $this->{$prop} = $value;
        }
        $this->save();
    }


    public function change($name, $value = null, $default = false)
    {
        if (isset($this->$name)) {
            $this->$name = $value;

            return $this->save();
        }

        if (!is_string($name) || !str_contains($name, '.')) {
            return $default;
        }
        $segments = explode('.', $name);
        $target = &$this->{$segments[0]};
        unset($segments[0]);
        if (is_array($target)) {
            foreach ($segments as $segment) {
                $target[$segment] = $value ?? $default;
            }
        }

        return $this->save();
    }

}
