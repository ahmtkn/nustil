<?php

namespace App\Http\Requests;


use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOwnAccountSettingsRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->id() === $this->route('user')->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$this->route('user')->id],
            'old_password' => [
                'nullable',
                'string',
                Rule::requiredIf(function () {
                    return $this->get('password') || $this->get('password_confirmation');
                }),
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, auth()->user()->password)) {
                        $fail(__('validation.current_password'));
                    }
                },
            ],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],

        ];
    }


}
