<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\Dashboard\Blog\PostController;

class BlogPostUpdateRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->can('blogs.update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'status' => ['nullable', 'string', 'max:255', 'in:draft,published,trashed'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'image' => ['nullable', 'image'],
            'categories' => ['required', 'array', 'min:1'],
            'categories.*' => ['required', 'integer', 'exists:blog_categories,id'],
            'locale' => ['required', 'string', 'max:255', 'in:'.implode(',', array_keys(getLocales()))],
        ];
    }

    protected function prepareForValidation()
    {
        if(!$this->has('locale')) {
            $this->merge([
                'locale' => app()->getLocale(),
            ]);
        }
        $this->merge([
            'tags' => PostController::detectKeywords($this->body),
        ]);
        if(!$this->has('slug')){
            $this->merge([
                'slug' => \Str::slug($this->title),
            ]);
        }
    }

}
