<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Settings\GeneralSettings;
use App\Http\Requests\NewsletterSubscriptionRequest;

class NewsletterController extends Controller
{

    public GeneralSettings $settings;

    public function __construct(GeneralSettings $settings)
    {
        $this->settings = $settings;
        parent::__construct($settings);
    }

    public function subscribe(NewsletterSubscriptionRequest $request){

    }
}
