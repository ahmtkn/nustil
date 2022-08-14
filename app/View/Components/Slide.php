<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Slide as SlideModel;
use Illuminate\Contracts\View\View;

class Slide extends Component
{

    public SlideModel $slide;

    public int $itemCount;

    public function __construct(SlideModel $slide, int $itemCount = 0)
    {
        $this->slide = $slide;
        $this->itemCount = $itemCount ?? 0;
    }

    public function render(): View
    {
        return view('components.slide');
    }

}
