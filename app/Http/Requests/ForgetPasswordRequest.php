<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForgetPasswordRequest extends FormRequest
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
            'email' => 'required|email:rfc,dns,filter|exists:users,email',
        ];
    }

    public function messages()
    {
        return [
            'email.exists' => 'Email n\'existe pas.',
            'email.email' => 'Email non valide.',
            'email.required' => 'Email requis.'
        ];
    }
}
