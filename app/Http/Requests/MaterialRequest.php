<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MaterialRequest extends FormRequest
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
        return[
            'name'              => 'required|string',
            'unit_id'           => 'required',
            'price'             => 'required'
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "Material name required",
            "unit_id.required" => "Unit name required",
            "price.required" => "Price required",
        ];
    }
}
