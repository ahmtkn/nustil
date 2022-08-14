<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Slider extends Component
{

    public $slides;

    public function __construct()
    {
        $locale = app()->getLocale();
        $this->slides = cache()->remember('slides_'.$locale, 86400, function () use ($locale) {
            return \App\Models\Slide::with('image')->active()->locale($locale)->orderBy('id')->get();
        });
    }

    public function render(): View
    {
        return view('components.slider');
    }

}
