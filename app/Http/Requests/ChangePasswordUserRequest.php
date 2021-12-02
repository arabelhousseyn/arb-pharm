<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordUserRequest extends FormRequest
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
            'old_password' => 'required',
            'new_password' => 'required',
            're_new_password' => 'required',
        ];
    }

    public function messages()
    {
        return  [
            'old_password.required' => 'Ancien mote de passe requis.',
            'new_password.required' => 'Nouveaux mote de passe requis.',
            're_new_password.required' => 'Nouveaux mote de passe requis.',

        ];
    }
}
