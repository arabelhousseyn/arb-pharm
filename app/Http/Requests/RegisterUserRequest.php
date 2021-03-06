<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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
            'phone' => 'required|digits:10|unique:users',
            'email' => 'required|unique:users|email:rfc,dns,filter',
            'password' => 'required',
            'commercial_name' => 'required',
            'social_name' => 'required',
            'num_rc' => 'required',
            'activity_code' => 'required',
            'nif' => 'required'
        ];
    }

    public function messages()
    {
        return [
           'phone.required' => 'Numéro de téléphone requis.',
            'phone.digits' => 'Le numéro de téléphone doit avoir 10 chiffres.',
            'phone.unique' => 'Le numéro de téléphone doit être unique.',
            'email.required' => 'E-mail requis.',
            'email.unique' => 'E-mail doit être unique.',
            'email.email' => 'E-mail doit être réel requis.',
            'password.required' => 'Mote de passe requis.',
            'commercial_name.required' => 'Document commercial requis.',
            'social_name.required' => 'Nom sociale requis.',
            'num_rc.required' => 'Numéro de RC requis.',
            'activity_code.required' => 'Code d\'activité requis.'
        ];
    }
}
