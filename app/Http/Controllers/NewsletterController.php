<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Settings\GeneralSettings;
use App\Http\Requests\NewsletterSubscriptionRequest;

class NewsletterController extends Controller
{

    public function __construct(public GeneralSettings $settings)
    {
        parent::__construct();
    }

    public function subscribe(NewsletterSubscriptionRequest $request){

    }
}
