<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsertRequestEstimateRequest extends FormRequest
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
            'product_name' => 'required',
            'amount' => 'required',
            'mark' => 'required',
            'images' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'product_name.required' => 'Nom du produit requis.',
            'amount.required' => 'Quantité requis.',
            'mark.required' => 'Marque requis.',
            'images.required' => 'images requis.',
        ];
    }
}
