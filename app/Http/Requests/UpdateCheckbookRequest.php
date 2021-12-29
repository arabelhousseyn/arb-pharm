<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCheckbookRequest extends FormRequest
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
            'book_number' => 'required',
            'book_key_number' => 'required',
            'fullName' => 'required',
            'adress' => 'required',
            'phone' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'book_number.required' => 'Numéro du carnet requis.',
            'book_key_number.required' => 'Clé requis',
            'fullName.required' => 'Nom complete requis',
            'adress.required' => 'Adresse requis',
            'phone.required' => 'Téléphone requis',
        ];
    }
}
