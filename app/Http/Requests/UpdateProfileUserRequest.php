<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileUserRequest extends FormRequest
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
            'commercial_name' => 'required',
            'num_rc' => 'required',
            'nif' => 'required',
            'nis' => 'required',
            'num_ar' => 'required',
            'pro_card' => 'required',
            'adress' => 'required',
            'activity_code' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'commercial_name.required' => 'Nom commercial requis.',
            'nif.required' => 'nif requis.',
            'nis.required' => 'nis requis.',
            'num_ar.required' => 'Numéro AR requis.',
            'pro_card.required' => 'Carte professionelle requis.',
            'adress.required' => 'Adresse requis.',
            'activity_code.required' => 'Code d\'activité requis.',
            'num_rc.required' => 'Numéro de RC requis.'
        ];
    }
}
