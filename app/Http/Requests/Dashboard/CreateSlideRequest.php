<?php

namespace App\Http\Requests\Dashboard;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class CreateSlideRequest extends FormRequest
{

    protected array $emptyButton = [
        "text" => null,
        "color" => "slate",
        "href" => null,
        "target" => "_self",
    ];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->can('menus.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => ['nullable', 'string'],
            'subtitle' => ['nullable', 'string'],
            'buttons' => ['sometimes', 'array'],
            'published_at' => ['required', 'date'],
            'expires_at' => ['required', 'date'],
            'image' => ['required', 'image'],
            'locale' => ['required', 'string', 'in:'.implode(',', array_keys(getLocales()))],
        ];
    }

    protected function prepareForValidation()
    {
        foreach (['published_at', 'expires_at'] as $field) {
            if ($this->has($field)) {
                $time = str_replace('/', '-', $this->get($field));
                $this->merge([$field => Carbon::createFromTimestamp(strtotime($time))]);
            }
        }
        if ($this->has('button') && array_diff($this->get('button'), $this->emptyButton)) {
            $this->merge(['buttons' => [$this->get('button')]]);
        }
        if (!$this->has('locale')) {
            $this->merge(['locale' => app()->getLocale()]);
        }
    }

}
