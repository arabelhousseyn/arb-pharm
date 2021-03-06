<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old_password' => ['required',Password::default()],
            'new_password' => ['required','confirmed',Password::default()],
        ];
    }

    public function messages()
    {
        return [
            'old_password.required' => 'Ancien mot de passe requis.',
            'new_password.required' => 'Nouveau mot de passe requis.',
            'new_password.confirmed' => 'Nouveau mot de passe ne correspondent pas .',
        ];
    }
}
