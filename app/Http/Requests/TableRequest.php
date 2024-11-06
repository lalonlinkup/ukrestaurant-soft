<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TableRequest extends FormRequest
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
        $rules = array(
            'name'          => 'required',
            'table_type_id' => 'required',
            'floor_id'      => 'required',
            'incharge_id'   => 'required',
            'capacity'      => 'required'
        );

        return $rules;
    }
}
