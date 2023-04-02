<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
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
        $aryRule =  [
            'name' => "required|unique:slider,name,".$this->id,
            'title' => 'required',
            'description' => 'required|min:3|max:255',
            'image' => 'required|max:5000|mimes:jpeg,png,jpg',
            'status' => 'required|numeric',
            'type_slider' => 'required|numeric|max:1',
            'related_id' => 'required|numeric',
        ];
        // check neeus ton tai this->id thi xoa requried trong image cuar aryrule
        if($this->id){
            $aryRule['image'] = 'max:5000|mimes:jpeg,png,jpg';
        }
        return $aryRule;
    }

    public function messages()
    {
        return[
            'required' => ':attribute must be filled',
            'max' => ':attribute is too long(max: 255 characters)',
            'min' => ':attribute is too short(min: 3 characters)',
            'numeric' => ':attribute must be number',
        ];
    }
}
