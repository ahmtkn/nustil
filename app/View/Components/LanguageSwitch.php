<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class LanguageSwitch extends Component
{

    public $alignmentClasses;

    public $width;

    public function __construct($align = 'right')
    {
        $this->width = (count(getLocales())  + 3).'rem';
        switch ($align) {
            case 'left':
                $this->alignmentClasses = 'origin-top-left left-0';
                break;
            case 'top':
                $this->alignmentClasses = 'origin-top';
                break;
            case 'right':
            default:
                $this->alignmentClasses = 'origin-top-right right-0';
                break;
        }
    }

    public function render(): View
    {
        return view('components.language-switch');
    }

}
