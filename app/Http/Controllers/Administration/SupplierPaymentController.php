<?php

namespace App\Http\Controllers\Administration;

use Carbon\Carbon;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\SupplierPayment;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SupplierPaymentRequest;

class SupplierPaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $payments = SupplierPayment::with('bankAccount', 'addBy');

        if (!empty($request->type)) {
            $payments = $payments->where('type', $request->type);
        }
        if (!empty($request->supplierId)) {
            $payments = $payments->where('supplier_id', $request->supplierId);
        }
        
        if (!empty($request->dateFrom) && !empty($request->dateTo)) {
            $payments = $payments->whereBetween('date', [$request->dateFrom, $request->dateTo]);
        }

        $payments = $payments->latest()->get();

        foreach ($payments as $key => $item) {
            $item->supplier = DB::select("select * from suppliers where id = ?", [$item->supplier_id])[0];
        }

        return response()->json($payments);
    }

    public function create()
    {
        return view('administration.account.supplierPayment');
    }

    public function store(SupplierPaymentRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        try {
            $data = new SupplierPayment();
            $supplierPaymentKeys = $request->except('id');
            foreach (array_keys($supplierPaymentKeys) as $key) {
                $data->$key = $request->$key;
            }

            $data->invoice = generateCode("Supplier_Payment", 'TR');
            $data->added_by = Auth::user()->id;
            $data->last_update_ip = request()->ip();
            $data->save();

            return response()->json(['status' => true, 'message' => 'Supplier Payment Insert successfully', 'paymentId' => $data->id], 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function update(SupplierPaymentRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        try {
            $data = SupplierPayment::find($request->id);
            $supplierPaymentKeys = $request->except('id');
            foreach (array_keys($supplierPaymentKeys) as $key) {
                $data->$key = $request->$key;
            }

            $data->updated_by = Auth::user()->id;
            $data->updated_at = Carbon::now();
            $data->last_update_ip = request()->ip();
            $data->update();
            return response()->json(['status' => true, 'message' => 'Supplier Payment Update successfully', 'paymentId' => $data->id], 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $data = SupplierPayment::find($request->id);

            $data->status = 'd';
            $data->last_update_ip = request()->ip();
            $data->deleted_by = Auth::user()->id;
            $data->update();

            $data->delete();
            return response()->json("Supplier payment delete successfully");
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function supplierDue()
    {
        return view('administration.reports.supplierdue');
    }

    public function getsupplierDue(Request $request)
    {

        try {
            $supplierDue = Supplier::supplierDue($request);

            return response()->json($supplierDue, 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    // public function getsupplierLedger(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'supplierId' => 'required'
    //     ], ['supplierId.required' => 'Supplier is empty']);
    //     if ($validator->fails()) return send_error("Validation Error", $validator->errors(), 422);
    //     try {
    //         $ledger = Supplier::supplierLedger($request);
    //         return response()->json($ledger, 200);
    //     } catch (\Throwable $th) {
    //         return send_error('Something went worng', $th->getMessage());
    //     }
    // }

    // public function supplierLedger()
    // {
    //     return view('administration.reports.supplierLedger');
    // }

    public function supplierPaymentHistory()
    {
        return view('administration.reports.supplierPaymentHistory');
    }

    public function invoice($id)
    {
        $payment = SupplierPayment::with('supplier', 'bankAccount')->where('id', $id)->first();
        return view('administration.account.paymentInvoice', compact('payment'));
    }
}
