<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            'code_verification' => 'required|exists:users,code_verification',
            'new_password' => 'required|confirmed'
        ];
    }

    public function messages()
    {
        return [
            'code_verification.required' => 'Code de vérification requis.',
            'code_verification.exists' => 'Code de vérification n\'exsiste pas ou expiré.',
            'new_password' => 'Nouveau mot de passe requis.'
        ];
    }
}
