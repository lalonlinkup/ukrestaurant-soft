<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DisposalRequest extends FormRequest
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
            'disposal.room_id' => 'required',
            'disposal.date' => 'required',
            'disposal.invoice' => 'required',
            'disposal.total' => 'required',
            'disposal.total' => 'required',
            'carts' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'disposal.room_id.required' => 'Room name required',
            'disposal.date.required' => 'Purchase date required',
            'disposal.invoice.required' => 'Purchase invoice required',
            'disposal.total.required' => 'Purchase total required',
            'carts.required' => 'Cart is empty',
        ];
    }
}