<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
            'invoice' => 'required|string',
            'date' => 'required',
            'table_id' => 'required',
            'service_head_id' => 'required',
            'amount' => 'required',
        ];
    }

    public function messages() {
        return [
            "table_id.required" => "Table name required",
            "service_head_id.required" => "Service head name required"
        ];
    }
}
