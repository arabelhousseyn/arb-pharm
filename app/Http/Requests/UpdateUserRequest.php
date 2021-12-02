<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'phone' => 'required|digits:10',
            'email' => 'required|email:rfc,dns,filter',
        ];
    }

    public function messages()
    {
        return  [
            'phone.required' => 'Téléphone requis.',
            'phone.digits' => 'Téléphone doit être 10 chiffres.',
            'phone.unique' => 'Téléphone doit être unique.',
            'email.required' => 'E-mail requis.',
            'email.email' => 'E-mail doit être valide.',
            'email.unique' => 'E-mail doit être unique.',
        ];
    }
}
