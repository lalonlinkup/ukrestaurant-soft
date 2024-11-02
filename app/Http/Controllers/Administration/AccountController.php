<?php

namespace App\Http\Controllers\Administration;

use Carbon\Carbon;
use App\Models\Account;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use App\Models\CashTransaction;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AccountRequest;
use App\Http\Requests\CashTransactionRequest;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $accounts = Account::latest()->get();
        return response()->json($accounts);
    }

    public function create()
    {
        if (!checkAccess('account')) {
            return view('error.unauthorize');
        }

        $code = generateCode("Account", 'A');
        return view('administration.account.index', compact('code'));
    }

    public function store(AccountRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        $checkAccount = Account::where('name', $request->name)->first();
        if (!empty($checkAccount)) return send_error("This name have been already taken", null, 422);

        try {
            $check = DB::table('accounts')->where('deleted_at', '!=', NULL)->where('name', $request->name)->first();;
            if (!empty($check)) {
                DB::select("UPDATE accounts SET deleted_by = NULL, deleted_at = NULL , status = 'a' WHERE id = ?", [$check->id]);
            } else {
                $data                  = new Account();
                $data->code            = generateCode("Account", 'A');
                $data->name            = $request->name;
                $data->description     = $request->description;
                $data->added_by        = Auth::user()->id;
                $data->last_update_ip  = request()->ip();;
                $data->save();
            }
            return response()->json(['message'=> "Account insert successfully", 'code' => generateCode("Account", 'A')]);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function update(AccountRequest $request)
    {

        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        $checkAccount = Account::where('id', '!=', $request->id)->where('name', $request->name)->first();
        if (!empty($checkAccount)) return send_error("This name have been already taken", null, 422);
        try {
            $data                  = Account::find($request->id);
            $data->code            = $request->code;
            $data->name            = $request->name;
            $data->description     = $request->description;
            $data->updated_by      = Auth::user()->id;
            $data->updated_at      = Carbon::now();
            $data->last_update_ip  = request()->ip();
            $data->update();

            return response()->json(['message' => "Account update successfully", 'code' => generateCode("Account", 'A')]);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $data                 = Account::find($request->id);
            $data->status         = 'd';
            $data->last_update_ip = request()->ip();
            $data->deleted_by     = Auth::user()->id;
            $data->update();

            $data->delete();
            return response()->json("Account delete successfully");
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function getCashTransaction(Request $request)
    {
        $transactions = CashTransaction::with('account', 'addBy');

        if (!empty($request->type)) {
            $transactions = $transactions->where('type', $request->type);
        }

        if (isset($request->accountId) && $request->accountId != null) {
            $transactions = $transactions->where('account_id', $request->accountId);
        }

        if (!empty($request->dateFrom) && !empty($request->dateTo)) {
            $transactions = $transactions->whereBetween('date', [$request->dateFrom, $request->dateTo]);
        }

        $transactions = $transactions->get();

        return response()->json($transactions);
    }

    public function cashTransaction()
    {
        if (!checkAccess('cashTransaction')) {
            return view('error.unauthorize');
        }

        $code = transactionGenerate("Cash_Transaction", 'T');
        return view('administration.account.cashTransaction', compact('code'));
    }

    public function cashTransactionStore(CashTransactionRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        try {
            $data = new CashTransaction();
            $cashTransactionKeys = $request->except('id', 'code');
            foreach (array_keys($cashTransactionKeys) as $key) {
                $data->$key = $request->$key;
            }
            $data->code = transactionGenerate("Cash_Transaction", 'T');

            $data->added_by        = Auth::user()->id;
            $data->last_update_ip  = request()->ip();
            $data->save();

            return response()->json(['message' => "Cash Transaction Insert successfully", 'code' => transactionGenerate("Cash_Transaction", 'T')]);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function cashTransactionUpdate(CashTransactionRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);

        try {
            $data = CashTransaction::find($request->id);
            $cashTransactionKeys = $request->except('id');
            foreach (array_keys($cashTransactionKeys) as $key) {
                $data->$key = $request->$key;
            }

            $data->updated_by = Auth::user()->id;
            $data->updated_at = Carbon::now();
            $data->last_update_ip = request()->ip();
            $data->update();

            return response()->json(['message' => "Cash Transaction Update successfully", 'code' => transactionGenerate("Cash_Transaction", 'T')]);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function cashTransactionDestroy(Request $request)
    {
        try {
            $data = CashTransaction::find($request->id);
            $data->status = 'd';
            $data->last_update_ip = request()->ip();
            $data->deleted_by = Auth::user()->id;
            $data->update();

            $data->delete();
            return response()->json("Cash Transaction Delete successfully");
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function cashView()
    {
        $data['cash_transaction_summary'] = Account::cashTransactionSummary()[0];
        $data['bank_transaction_summary'] = BankAccount::bankTransactionSummary();
        return view('administration.reports.cashview', $data);
    }

    public function cashStatement()
    {
        if (!checkAccess('cashStatement')) {
            return view('error.unauthorize');
        }
        return view('administration.reports.cashstatement');
    }

    public function cashLedger()
    {
        if (!checkAccess('cashLedger')) {
            return view('error.unauthorize');
        }
        return view('administration.reports.cashledger');
    }

    public function getCashLedger(Request $request)
    {
        try {
            $ledger = Account::cashLedger($request);
            return response()->json($ledger, 200);
        } catch (\Throwable $th) {
            send_error("Something went wrong", $th->getMessage());
        }
    }

    public function cashTransactionReport()
    {
        if (!checkAccess('cashTransaction')) {
            return view('error.unauthorize');
        }

        return view('administration.account.cashTransactionReport');
    }
}
