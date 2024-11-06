<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'order.date'      => 'required',
            'order.invoice'   => 'required',
            'order.sub_total' => 'required',
            'order.total'     => 'required',
            'order.paid'      => 'required',
            'order.cashPaid'  => 'required',
            'order.bankPaid'  => 'required',
            'order.due'       => 'required',
            'carts'           => 'required',
            'customer.type'   => 'required'
        ];

        if ($this->customer['type'] == 'N' && (empty($this->customer['name']) || empty($this->customer['phone']))) {
            $rules['customer.name'] = 'required';
            $rules['customer.phone'] = 'required';
        }
        if ($this->order['bankPaid'] > 0) {
            $rules['order.bank_account_id'] = 'required';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'order.date.required'            => 'Order date required',
            'order.invoice.required'         => 'Order invoice required',
            'order.sub_total.required'       => 'Order subtotal required',
            'order.total.required'           => 'Order total required',
            'order.paid.required'            => 'Order paid required',
            'order.due.required'             => 'Order due required',
            'order.bank_account_id.required' => 'Select Bank Account',
            'carts.required'                 => 'Cart is empty',
            'customer.type.required'         => 'Select customer',
            'customer.name.required'         => 'Guest name is empty',
            'customer.phone.required'        => 'Guest phone is empty',
        ];
    }
}
