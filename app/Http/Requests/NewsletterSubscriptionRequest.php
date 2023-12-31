<?php

namespace App\Http\Requests;

use App\Settings\GeneralSettings;
use Illuminate\Foundation\Http\FormRequest;

class NewsletterSubscriptionRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $settings = app(GeneralSettings::class);

        return $settings->newsletter['enabled'];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => ['required', 'email'],
        ];
    }

}
