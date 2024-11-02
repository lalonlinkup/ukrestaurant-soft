<?php

namespace App\Http\Controllers\Administration;

use Carbon\Carbon;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\CustomerPayment;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CustomerPaymentRequest;

class CustomerPaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $payments = CustomerPayment::with('bankAccount', 'addBy');

        if (!empty($request->type)) {
            $payments = $payments->where('type', $request->type);
        }
        if (!empty($request->customerId)) {
            $payments = $payments->where('customer_id', $request->customerId);
        }
        if (!empty($request->bookingId)) {
            $payments = $payments->where('booking_id', $request->bookingId);
        }

        if (!empty($request->dateFrom) && !empty($request->dateTo)) {
            $payments = $payments->whereBetween('date', [$request->dateFrom, $request->dateTo]);
        }

        $payments = $payments->latest()->get();

        foreach ($payments as $key => $item) {
            $item->customer = DB::select("select * from customers where id = ?", [$item->customer_id])[0];
        }

        return response()->json($payments);
    }

    public function create($id = null)
    {
        return view('administration.account.customerPayment', compact('id'));
    }

    public function store(CustomerPaymentRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        try {
            $data = new CustomerPayment();
            $customerPaymentKeys = $request->except('id', 'sms');
            foreach (array_keys($customerPaymentKeys) as $key) {
                $data->$key = $request->$key;
            }

            $data->invoice = generateCode("Customer_Payment", 'TR');
            $data->added_by = Auth::user()->id;
            $data->last_update_ip = request()->ip();
            $data->save();

            // send sms
            // if (session('organization')->sms_service == 'on') {
            //     $customer = Customer::where('id', $request->customer_id)->first();
            //     if (!empty($customer) && preg_match("/(^(01){1}[3456789]{1}(\d){8})$/", trim($customer->phone)) == 1) {
            //         send_sms('payment', $customer, $data);
            //     }
            // }
            return response()->json(['message' => "Customer Payment Insert successfully", 'paymentId' => $data->id]);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function update(CustomerPaymentRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        try {
            $data = CustomerPayment::find($request->id);
            $customerPaymentKeys = $request->except('id');
            foreach (array_keys($customerPaymentKeys) as $key) {
                $data->$key = $request->$key;
            }

            $data->updated_by = Auth::user()->id;
            $data->updated_at = Carbon::now();
            $data->last_update_ip = request()->ip();
            $data->update();

            return response()->json(['message' => "Customer Payment Update successfully", 'paymentId' => $data->id]);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $data = CustomerPayment::find($request->id);

            $data->status = 'd';
            $data->last_update_ip = request()->ip();
            $data->deleted_by = Auth::user()->id;
            $data->update();

            $data->delete();
            return response()->json("Customer payment delete successfully");
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function getCustomerDue(Request $request)
    {

        try {
            $clauses = "";
            if (isset($request->customerId) && $request->customerId != null) {
                $clauses .= " and c.id = '$request->customerId'";
            }
            if (isset($request->districtId) && $request->districtId != null) {
                $clauses .= " and c.district_id = '$request->districtId'";
            }
            if (isset($request->bookingId) && $request->bookingId != null) {
                $clauses .= " and bkm.id = '$request->bookingId'";
            }

            $customerDue = Customer::customerDue($clauses);

            return response()->json($customerDue, 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    // public function invoice($slug, $id)
    // {
    //     if ($slug == 'customer') {
    //         $payment = CustomerPayment::with('customer', 'bankAccount')->where('id', $id)->first();
    //     } else {
    //         $payment = SupplierPayment::with('supplier', 'bankAccount')->where('id', $id)->first();
    //     }
    //     return view('administration.account.paymentInvoice', compact('payment', 'slug'));
    // }

    // public function customerDue()
    // {
    //     return view('administration.reports.customerdue');
    // }

    // public function getcustomerLedger(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'customerId' => 'required'
    //     ], ['customerId.required' => 'Customer is empty']);
    //     if ($validator->fails()) return send_error("Validation Error", $validator->errors(), 422);
    //     try {
    //         $ledger = Customer::customerLedger($request);
    //         return response()->json($ledger, 200);
    //     } catch (\Throwable $th) {
    //         return send_error('Something went worng', $th->getMessage());
    //     }
    // }

    // public function customerLedger()
    // {
    //     return view('administration.reports.customerLedger');
    // }

    public function customerPaymentHistory()
    {
        return view('administration.reports.customerPaymentHistory');
    }
}
