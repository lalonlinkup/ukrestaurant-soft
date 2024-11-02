<?php

namespace App\Http\Controllers\Administration;

use Carbon\Carbon;
use App\Models\LoanAccount;
use Illuminate\Http\Request;
use App\Models\LoanTransaction;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoanAccountRequest;
use App\Http\Requests\LoanTransactionRequest;
use Illuminate\Support\Facades\Validator;

class LoanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function accountCreate()
    {
        if (!checkAccess('loanAccounts')) {
            return view('error.unauthorize');
        }

        return view('administration.account.loan.account');
    }

    public function getAccounts(Request $request)
    {
        $loanAccounts = LoanAccount::where('status', 'a');
        if (!empty($request->dateFrom) && !empty($request->dateTo)) {
            $loanAccounts = $loanAccounts->whereBetween(DB::raw("DATE(created_at)"), [$request->dateFrom, $request->dateTo]);
        }
        $loanAccounts = $loanAccounts->get();
        return response()->json($loanAccounts);
    }

    public function accountStore(LoanAccountRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        $checkAccount = LoanAccount::where('name', $request->name)->where('number', $request->number)->first();
        if (!empty($checkAccount)) return send_error("This account have been already taken", null, 422);

        try {
            $check = DB::table('loan_accounts')->where('deleted_at', '!=', NULL)->where('name', $request->name)->where('number', $request->number)->first();
            if (!empty($check)) {
                DB::select("UPDATE loan_accounts SET deleted_by = NULL, deleted_at = NULL , status = 'a' WHERE id = ?", [$check->id]);
            } else {
                $data = new LoanAccount();
                $loanAccountKeys = $request->except('id');
                foreach (array_keys($loanAccountKeys) as $key) {
                    $data->$key = $request->$key;
                }
                $data->added_by = Auth::user()->id;
                $data->last_update_ip = request()->ip();
                $data->save();
            }
            return response()->json(['status' => true, 'message' => "Account insert successfully"]);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function accountUpdate(LoanAccountRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        $checkAccount = LoanAccount::where('name', $request->name)->where('number', $request->number)->where('id', '!=', $request->id)->first();
        if (!empty($checkAccount)) return send_error("This account have been already taken", null, 422);

        try {
            $data = LoanAccount::find($request->id);
            $loanAccountKeys = $request->except('id');
            foreach (array_keys($loanAccountKeys) as $key) {
                $data->$key = $request->$key;
            }
            $data->updated_by = Auth::user()->id;
            $data->updated_at = Carbon::now();
            $data->last_update_ip = request()->ip();
            $data->update();
            return response()->json(['status' => true, 'message' => "Account Update successfully"]);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function accountDestroy(Request $request)
    {
        try {
            $data = LoanAccount::find($request->id);
            $data->status = $data->status == 'a' ? 'd' : 'a';
            $message = $data->status == 'a' ? 'Account Active successfully!' : 'Account Inactive successfully!';
            $data->last_update_ip = request()->ip();
            $data->update();

            return response()->json($message);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function loanTransaction()
    {
        if (!checkAccess('loanTransactions')) {
            return view('error.unauthorize');
        }

        $code = generateCode("Loan_transaction", 'LT');
        return view('administration.account.loan.transaction', compact('code'));
    }

    public function loanTransactionStore(LoanTransactionRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        try {
            $data = new LoanTransaction();
            $loanTransactionKeys = $request->except('id');
            foreach (array_keys($loanTransactionKeys) as $key) {
                $data->$key = $request->$key;
            }
            $data->invoice = invoiceGenerate("Loan_Transaction", "TR");
            $data->added_by = Auth::user()->id;
            $data->last_update_ip = request()->ip();
            $data->organization_id = session('organization')->id;
            $data->save();

            return response()->json(['status' => true, 'message' => "Loan Transaction Insert successfully", 'code' => generateCode("Loan_Transaction", 'LT')]);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function loanTransactionUpdate(LoanTransactionRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);

        try {
            $data = LoanTransaction::find($request->id);
            $loanTransactionKeys = $request->except('id');
            foreach (array_keys($loanTransactionKeys) as $key) {
                $data->$key = $request->$key;
            }

            $data->updated_by = Auth::user()->id;
            $data->updated_at = Carbon::now();
            $data->last_update_ip = request()->ip();
            $data->update();

            return response()->json(['status' => true, 'message' => "Loan Transaction Update successfully", 'code' => generateCode("Loan_Transaction", 'LT')]);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function getLoanTransaction(Request $request)
    {
        $transactions = LoanTransaction::with('loanAccount', 'addBy');

        if (isset($request->accountId) && $request->accountId != '') {
            $transactions = $transactions->where('loan_account_id', $request->accountId);
        }

        if (isset($request->type) && $request->type != '') {
            $transactions = $transactions->where('type', $request->type);
        }

        if (!empty($request->dateFrom) && !empty($request->dateTo)) {
            $transactions = $transactions->whereBetween('date', [$request->dateFrom, $request->dateTo]);
        }
        $transactions = $transactions->latest('id')->get();

        return response()->json($transactions, 200);
    }

    public function loanTransactionDestroy(Request $request)
    {
        try {
            $data = LoanTransaction::find($request->id);
            $data->status = 'd';
            $data->deleted_by = Auth::user()->id;
            $data->update();

            $data->delete();
            return response()->json(['status' => true, 'message' => "Loan Transaction Delete successfully"]);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function loanView()
    {
        if (!checkAccess('loanView')) {
            return view('error.unauthorize');
        }

        $data['loan_transaction_summary'] = LoanAccount::loanTransactionSummary();
        return view('administration.account.loan.view', $data);
    }

    public function loanTransactionReport()
    {
        if (!checkAccess('loanTransactionReport')) {
            return view('error.unauthorize');
        }

        return view('administration.account.loan.report');
    }

    public function loanLedger()
    {
        if (!checkAccess('loanLedger')) {
            return view('error.unauthorize');
        }

        return view('administration.account.loan.ledger');
    }

    public function getLoanLedger(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'accountId' => 'required'
        ], ['accountId.required' => 'Account is required!']);
        if ($validator->fails()) return send_error("Validation Error", $validator->errors(), 422);
        try {
            $ledger = LoanTransaction::loanLedger($request);
            return response()->json($ledger, 200);
        } catch (\Throwable $th) {
            return send_error('Something went worng', $th->getMessage());
        }
    }

    public function loanTransactionSummery(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'accountId' => 'required'
        ], ['accountId.required' => 'Account is required!']);
        if ($validator->fails()) return send_error("Validation Error", $validator->errors(), 422);
        try {
            $transaction = LoanAccount::loanTransactionSummary($request->accountId);
            return response()->json($transaction, 200);
        } catch (\Throwable $th) {
            return send_error('Something went worng', $th->getMessage());
        }
    }
}
