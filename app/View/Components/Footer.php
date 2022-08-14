<?php

namespace App\View\Components;

use App\Traits\LoadsSettings;
use Illuminate\View\Component;
use App\Settings\GeneralSettings;

class Footer extends Component
{



    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function render()
    {
        return view('components.footer');
    }

}
