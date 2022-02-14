<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOfferRequest extends FormRequest
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
            'user_id' => 'required',
            'request_estimate_id' => 'required',
            'product_name' => 'required',
            'amount' => 'required',
            'mark' => 'required',
            'price' => 'required',
            'images' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'Erreur veuillez réessayer.',
            'request_estimate_id.required' => 'Erreur veuillez réessayer.',
            'product_name.required' => 'Produit requis.',
            'amount.required' => 'Quantité requis.',
            'mark.required' => 'Marque requis.',
            'price.required' => 'Prix requis.',
            'images.required' => 'Images requis.',
        ];
    }
}
