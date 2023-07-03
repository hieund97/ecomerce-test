<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiscountRequest extends FormRequest
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
            'name' => 'required|unique:discounts,name,'.$this->id,
            'code' => 'required|min:3|max:255',
            'related_id' => 'required',
            'value' => 'required|numeric',
            'type_discount' => 'numeric',
            'start' => 'required',
            'end' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute must be filled',
            'max' => ':attribute is too long(max: 255 characters)',
            'min' => ':attribute is too short(min: 3 characters)',
            'numeric' => ':attribute must be number',
        ];
    }
}
