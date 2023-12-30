<?php

namespace App\Http\Requests\Dashboard\Category;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name'      => 'required|string|unique:categories,name',
            'parent_id' => 'nullable|integer|exists:categories,id',
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
            'name.required'     => trans('validation.required'),
            'name.string'       => trans('validation.string'),
            'name.unique'       => trans('validation.unique'),
            'parent_id.integer' => trans('validation.integer'),
        ];
    }
}
