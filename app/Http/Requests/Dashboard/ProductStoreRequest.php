<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->can('products.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'slug' => ['required', 'string', 'unique:products'],
            'color' => ['required', 'string'],
            'weight' => ['nullable', 'string'],
            'price' => ['nullable', 'string'],
            'amount' => ['nullable', 'string'],
            'is_pack' => ['nullable', 'string'],
            'locale' => ['required', 'string'],
            'tagline' => ['required', 'string'],
            'description' => ['required', 'string'],
            'status' => ['required', 'string'],
            'image' => ['required', 'image'],
            'ingredients' => ['nullable', 'array'],
            'nutritions' => ['nullable', 'array'],
            'categories' => ['nullable', 'array'],
            'purchase_link' => ['nullable', 'url', 'active_url'],

        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'slug' => \Str::slug($this->name.' '.$this->weight.'g'),
            'price' => $this->price ?? '0',
        ]);
    }

}
