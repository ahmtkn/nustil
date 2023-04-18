<?php

namespace App\Http\Requests\Dashboard;


use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->can('products.update');
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
            'slug' => ['required', 'string', 'unique:products,slug,'.$this->product->id],
            'color' => ['required', 'string'],
            'weight' => ['sometimes', 'string'],
            'price' => ['sometimes', 'string'],
            'amount' => ['sometimes', 'string'],
            'is_pack' => ['sometimes', 'string'],
            'locale' => ['required', 'string'],
            'tagline' => ['required', 'string'],
            'description' => ['required', 'string'],
            'status' => ['required', 'string'],
            'image' => ['sometimes', 'image'],
            'ingredients' => ['sometimes', 'array'],
            'nutritions' => ['sometimes', 'array'],
            'categories' => ['sometimes', 'array'],
            'purchase_link' => ['nullable', 'url', 'active_url'],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'slug' => Str::slug($this->name.' '.$this->weight.'g'),
            'price' => $this->price ?? '0',
        ]);


        if($this->has('nutritions')){
            $nutritions = [];
            foreach($this->input('nutritions') as $nutrition_id => $value){
                $nutritions[$nutrition_id] = floatval(Str::replace([',',' '], ['.',' '], Str::before($value, '/')));
            }
            $this->merge([
                'nutritions' => $nutritions
            ]);
        }
    }

}
