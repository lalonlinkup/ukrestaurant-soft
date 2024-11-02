<?php

namespace App\Http\Controllers\Administration;

use Carbon\Carbon;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use App\Models\BankTransaction;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\BankAccountRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\BankTransactionRequest;

class BankTransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $accounts = BankAccount::latest()->get();
        return response()->json($accounts);
    }

    public function create()
    {
        if (!checkAccess('bankAccounts')) {
            return view('error.unauthorize');
        }

        return view('administration.account.bankAccount');
    }

    public function store(BankAccountRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        $checkAccountNumber = BankAccount::where('number', $request->number)->first();
        if (!empty($checkAccountNumber)) return send_error("This account number have been already taken", null, 422);

        try {
            $check = DB::table('bank_accounts')->where('deleted_at', '!=', NULL)->where('name', $request->name)->first();;
            if (!empty($check)) {
                DB::select("UPDATE bank_accounts SET deleted_by = NULL, deleted_at = NULL , status = 'a' WHERE id = ?", [$check->id]);
            } else {
                $data = new BankAccount();
                $bankAccountKeys = $request->except('id');
                foreach (array_keys($bankAccountKeys) as $key) {
                    $data->$key = $request->$key;
                }
                $data->added_by = Auth::user()->id;
                $data->last_update_ip = request()->ip();;
                $data->save();
            }

            return response()->json(['message' => "Account insert successfully", 'code' => generateCode("Account", 'A')]);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function update(BankAccountRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        $checkAccountExits = BankAccount::where('id', '!=', $request->id)->where('number', $request->number)->first();
        if (!empty($checkAccountExits)) return send_error("This account number have been already taken", null, 422);
        try {
            $data = BankAccount::find($request->id);
            $bankAccountKeys = $request->except('id');
            foreach (array_keys($bankAccountKeys) as $key) {
                $data->$key = $request->$key;
            }
            $data->updated_by = Auth::user()->id;
            $data->updated_at = Carbon::now();
            $data->last_update_ip = request()->ip();
            $data->update();

            return response()->json(['' => "BankAccount update successfully", 'code' => generateCode("Account", 'A')]);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function changeStatus(Request $request)
    {
        try {
            $data = BankAccount::find($request->id);
            $data->status = $data->status == 'a' ? 'd' : 'a';
            $message = $data->status == 'a' ? 'Account Active successfully!' : 'Account Inactive successfully!';
            $data->update();
            return response()->json($message);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function getBankTransaction(Request $request)
    {
        $transactions = BankTransaction::with('bankAccount', 'addBy');

        if (!empty($request->type)) {
            $transactions = $transactions->where('type', $request->type);
        }

        if (!empty($request->dateFrom) && !empty($request->dateTo)) {
            $transactions = $transactions->whereBetween('date', [$request->dateFrom, $request->dateTo]);
        }

        $transactions = $transactions->get();

        return response()->json($transactions);
    }

    public function bankTransaction()
    {
        if (!checkAccess('bankTransaction')) {
            return view('error.unauthorize');
        }

        return view('administration.account.bankTransaction');
    }

    public function bankTransactionStore(BankTransactionRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        try {
            $data = new BankTransaction();
            $transactionKeys = $request->except('id');
            foreach (array_keys($transactionKeys) as $key) {
                $data->$key = $request->$key;
            }

            $data->added_by = Auth::user()->id;
            $data->last_update_ip = request()->ip();
            $data->save();

            return response()->json("Bank Transaction Insert successfully");
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function bankTransactionUpdate(BankTransactionRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);

        try {
            $data = BankTransaction::find($request->id);
            $transactionKeys = $request->except('id');
            foreach (array_keys($transactionKeys) as $key) {
                $data->$key = $request->$key;
            }

            $data->updated_by = Auth::user()->id;
            $data->updated_at = Carbon::now();
            $data->last_update_ip = request()->ip();
            $data->update();

            return response()->json("Bank Transaction Update successfully");
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function bankTransactionDestroy(Request $request)
    {
        try {
            $data = BankTransaction::find($request->id);
            $data->status = 'd';
            $data->last_update_ip = request()->ip();
            $data->deleted_by = Auth::user()->id;
            $data->update();

            $data->delete();
            return response()->json("Bank Transaction Delete successfully");
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function bankLedger()
    {
        return view('administration.reports.bankledger');
    }

    public function getBankTransactionSummary(Request $request)
    {
        $validator = Validator::make($request->all(), ['bankId' => 'required'], ['bankId.required' => 'Bank account is required']);
        if ($validator->fails()) return send_error("Validation Error", $validator->errors(), 422);

        try {
            $transaction = BankAccount::bankTransactionSummary($request->bankId);
            return response()->json($transaction, 200);
        } catch (\Throwable $th) {
            send_error("Something went wrong", $th->getMessage());
        }
    }

    public function getBankLedger(Request $request)
    {
        if ($request->for != 'report') {
            $validator = Validator::make($request->all(), ['bankId' => 'required'], ['bankId.required' => 'Bank account is required']);
            if ($validator->fails()) return send_error("Validation Error", $validator->errors(), 422);
        }
        try {
            $ledger = BankAccount::bankLedger($request);
            return response()->json($ledger, 200);
        } catch (\Throwable $th) {
            send_error("Something went wrong", $th->getMessage());
        }
    }

    public function bankTransactionRecord()
    {
        if (!checkAccess('bankTransactionReport')) {
            return view('error.unauthorize');
        }

        return view('administration.account.bankTransactionReport');
    }
}
