<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IssueReturnRequest extends FormRequest
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
            'issueReturn.date' => 'required',
            'issueReturn.total' => 'required',
            'issueReturn.room_id' => 'required',
            'carts' => 'required',
        ];

    }

    public function messages()
    {
        return [
            'issueReturn.room_id.required' => 'Room name required',
            'issueReturn.date.required' => 'Issue Return date required',
            'issueReturn.total.required' => 'Issue Return total required',
            'carts.required' => 'Cart is empty',
        ];
    }
}
