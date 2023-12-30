<?php

namespace App\Http\Requests\Dashboard\Product;

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
            'name'        => 'required|string',
            'category_id' => 'required|integer|exists:categories,id',
            'file'        => 'nullable|mimes:jpeg,jpg,png,webp|max:5048',
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
            'name.required'       => trans('validation.required'),
            'name.string'         => trans('validation.string'),
            'category_id.integer' => trans('validation.required'),
            'category_id.integer' => trans('validation.integer'),
            'file.integer'        => trans('validation.mimes'),
        ];
    }
}
