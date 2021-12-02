<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class insertUserRequest extends FormRequest
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
            'num_rc' => 'required',
            'nif' => 'required',
            'nis' => 'required',
            'num_ar' => 'required',
            'pro_card' => 'required',
            'adress' => 'required',
            'activity_code' => 'required',
            'images' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'phone.required' => 'Téléphone requis.',
            'phone.digits' => 'Téléphone doit être 10 chiffres.',
            'phone.unique' => 'Téléphone doit être unique.',
            'email.required' => 'E-mail requis.',
            'email.email' => 'E-mail doit être valide.',
            'email.unique' => 'E-mail doit être unique.',
            'password.required' => 'Mote de passe requis.',
            'commercial_name.required' => 'Nom commercial requis.',
            'nif.required' => 'nif requis.',
            'nis.required' => 'nis requis.',
            'num_ar.required' => 'Numéro AR requis.',
            'pro_card.required' => 'Carte professionelle requis.',
            'adress.required' => 'Adresse requis.',
            'activity_code.required' => 'Code d\'activité requis.',
            'num_rc.required' => 'Numéro de RC requis.',
            'images.required' => 'Paiments images requis.',
        ];
    }
}
