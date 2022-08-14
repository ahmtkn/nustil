<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SliderButton extends Component
{

    public ?string $text;

    public ?string $icon;

    public ?string $color;

    public ?string $href;

    public ?string $target;

    public function __construct(array $props)
    {
        $this->text = $props['text'] ?? null;
        $this->icon = $props['icon'] ?? null;
        $this->color = $props['color'] ?? 'emerald';
        $this->href = $props['href'] ?? '#';
        $this->target = $props['target'] ?? '_self';
    }

    public function render()
    {
        return view('components.slider-button');
    }

}
