<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
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
            'name'         => 'required',
            'room_type_id' => 'required',
            'floor_id'     => 'required',
            'category_id'  => 'required',
            'bed'          => 'required',
            'bath'         => 'required',
            'price'        => 'required'
        );

        return $rules;
    }
}
