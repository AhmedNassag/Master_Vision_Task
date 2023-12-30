<?php

namespace App\Http\Requests\Dashboard\ShopProduct;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'quantity'   => 'required|numeric',
            'shop_id'    => 'required|integer|exists:shops,id',
            'product_id' => 'required|integer|exists:products,id',
        ];
    }


    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function messages()
    {
        return [
            'quantity.required'  => trans('validation.required'),
            'quantity.numeric'   => trans('validation.numeric'),
            'shop_id.integer'    => trans('validation.required'),
            'shop_id.integer'    => trans('validation.integer'),
            'product_id.integer' => trans('validation.required'),
            'product_id.integer' => trans('validation.integer'),
        ];
    }
}
