<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManageRequest extends FormRequest
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
            'code'           => 'required',
            'name'           => 'required',
            'phone'          => 'required|max:15',
            'designation_id' => 'required',
        ];
    }

    public function messages()
    {
        return ["designation_id.required" => "Desigantion name required"];
    }
}
