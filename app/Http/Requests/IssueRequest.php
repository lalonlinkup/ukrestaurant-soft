<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IssueRequest extends FormRequest
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
            'issue.date' => 'required',
            'issue.invoice' => 'required',
            'issue.issue_to' => 'required',
            'issue.subtotal' => 'required',
            'issue.total' => 'required',
            'issue.room_id' => 'required',
            'carts' => 'required',
        ];

    }

    public function messages()
    {
        return [
            'issue.room_id.required' => 'Room name required',
            'issue.date.required' => 'Issue date required',
            'issue.invoice.required' => 'Issue invoice required',
            'issue.issue_to.required' => 'Issue To required',
            'issue.subtotal.required' => 'Issue subtotal required',
            'issue.total.required' => 'Issue total required',
            'carts.required' => 'Cart is empty',
        ];
    }
}
