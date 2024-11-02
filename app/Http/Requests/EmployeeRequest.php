<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
            'code'              => 'required|string',
            'name'              => 'required|string',
            'bio'               => 'max:20',
            'phone'             => 'required|min:11|max:15',
            'designation_id'    => 'required',
            'department_id'     => 'required',
            'joining'           => 'required|date',
            'gender'            => 'required|string',
            'dob'               => 'required|date',
            'email'             => 'required|email',
            'marital_status'    => 'required|string',
            'father_name'       => 'required|string',
            'mother_name'       => 'required|string',
            'present_address'   => 'required|string',
            'permanent_address' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            "designation_id.required" => "Designation name required",
            "department_id.required" => "Department name required"
        ];
    }
}
