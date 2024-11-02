<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoanTransactionRequest extends FormRequest
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
            'date' => 'required|date',
            'type' => 'required|string',
            'loan_account_id' => 'required',
            'amount' => 'required',
        ];
    }

    public function messages() {
        return ["loan_account_id.required" => "Loan Account required"];
    }
}
