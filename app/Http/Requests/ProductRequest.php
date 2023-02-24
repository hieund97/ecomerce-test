<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        // $this->request->id
        return [
            'name' => 'required',
            'description' => 'required|min:3|max:255',
            'details' => 'required|min:3',
            'sku' => 'required|unique:products',
            'price' => 'required|numeric',
            'quantity' => 'numeric|required',
            'is_new' => 'numeric',
            'is_sale' => 'numeric',
            'highlight' => 'numeric',
            'status' => 'required|numeric',
            'related_product_id' => 'nullable',
            'image' => 'required|max:5000|mimes:jpeg,png,jpg'
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
