<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;

class CreateRecipeRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:recipes,slug',
            'description' => 'required|string|max:255',
            'image' => ['required','image'],
            'ingredients' => 'required|array',
            'instructions' => 'required|array',
            'locale' => 'required|string|in:tr,en',
            'products' => 'required|array',
            'notes' => 'nullable|string|max:255',

        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'slug' => Str::slug($this->input('name')),
            'ingredients' => explode("\n", $this->input('ingredients')),
            'instructions' => explode("\n", $this->input('instructions')),
        ]);

    }

}
