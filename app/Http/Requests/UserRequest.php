<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $rules = [
            "name"     => "required",
            "username" => "required",
            "email"    => "required",
            "role" => "required",
        ];
        if (empty($this->id)) {
            $rules['password'] = 'required';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            "username.required" => "Username is required",
            "role.required" => "User role is required",
        ];
    }
}
