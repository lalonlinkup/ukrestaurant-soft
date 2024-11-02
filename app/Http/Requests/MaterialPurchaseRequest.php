<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MaterialPurchaseRequest extends FormRequest
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
            'purchase.supplier_id' => 'required',
            'purchase.date' => 'required',
            'purchase.invoice' => 'required',
            'purchase.subtotal' => 'required',
            'purchase.total' => 'required',
            'carts' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'purchase.supplier_id.required' => 'Supplier name required',
            'purchase.date.required' => 'Material Purchase date required',
            'purchase.invoice.required' => 'Material Purchase invoice required',
            'purchase.subtotal.required' => 'Purchase subtotal required',
            'purchase.total.required' => 'Purchase total required',
            'carts.required' => 'Cart is empty',
        ];
    }
}
