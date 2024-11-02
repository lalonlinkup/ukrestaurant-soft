<?php

namespace App\Http\Controllers\Administration;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\InvestmentAccount;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\InvestmentTransaction;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\InvestmentAccountRequest;
use App\Http\Requests\InvestmentTransactionRequest;

class InvestmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getAccounts()
    {
        $accounts = InvestmentAccount::latest()->get();
        return response()->json($accounts, 200);
    }

    public function accountCreate()
    {
        if (!checkAccess('investmentAccounts')) {
            return view('error.unauthorize');
        }

        $code = generateCode("Investment_account", 'IA');
        return view('administration.account.investment.account', compact('code'));
    }

    public function accountStore(InvestmentAccountRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        $checkAccount = InvestmentAccount::where('name', $request->name)->first();
        if (!empty($checkAccount)) return send_error("This name have been already taken", null, 422);

        try {
            $check = DB::table('accounts')->where('deleted_at', '!=', NULL)->where('name', $request->name)->first();;
            if (!empty($check)) {
                DB::select("UPDATE accounts SET deleted_by = NULL, deleted_at = NULL , status = 'a' WHERE id = ?", [$check->id]);
            } else {
                $data = new InvestmentAccount();
                $data->code = generateCode("Investment_account", 'IA');
                $data->name = $request->name;
                $data->description = $request->description;

                $data->added_by = Auth::user()->id;
                $data->last_update_ip = request()->ip();
                $data->save();
            }
            return response()->json(['status' => true, 'message' => 'Investment Account Create!', 'code' => generateCode("Investment_Account", 'A')], 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function accountUpdate(InvestmentAccountRequest $request)
    {

        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        $checkAccount = InvestmentAccount::where('id', '!=', $request->id)->where('name', $request->name)->first();
        if (!empty($checkAccount)) return send_error("This name have been already taken", null, 422);
        try {
            $data = InvestmentAccount::find($request->id);
            $data->code = $request->code;
            $data->name = $request->name;
            $data->description = $request->description;
            $data->updated_by = Auth::user()->id;
            $data->updated_at = Carbon::now();
            $data->last_update_ip = request()->ip();
            $data->organization_id = session('organization')->id;
            $data->update();

            return response()->json(['status' => true, 'message' => 'Investment Account Update!', 'code' => generateCode("Investment_Account", 'A')], 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function accountDestroy(Request $request)
    {
        try {
            $data = InvestmentAccount::find($request->id);
            $data->status = 'd';
            $data->last_update_ip = request()->ip();
            $data->deleted_by = Auth::user()->id;
            $data->update();

            $data->delete();
            return response()->json(['status' => true, 'message' => 'Investment Account Delete!'], 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function investmentTransaction()
    {
        if (!checkAccess('investmentTransactions')) {
            return view('error.unauthorize');
        }

        $code = generateCode("Investment_transaction", 'LT');
        return view('administration.account.investment.transaction', compact('code'));
    }

    public function investmentTransactionStore(InvestmentTransactionRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        try {
            $data = new InvestmentTransaction();
            $investmentTransactionKeys = $request->except('id');
            foreach (array_keys($investmentTransactionKeys) as $key) {
                $data->$key = $request->$key;
            }
            $data->invoice = invoiceGenerate("Investment_Transaction", "TR");
            $data->added_by = Auth::user()->id;
            $data->last_update_ip = request()->ip();
            $data->save();

            return response()->json(['status' => true, 'message' => 'Investment Transaction Create!', 'code' => generateCode("Investment_Transaction", 'TR')], 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function investmentTransactionUpdate(InvestmentTransactionRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);

        try {
            $data = InvestmentTransaction::find($request->id);
            $investmentTransactionKeys = $request->except('id');
            foreach (array_keys($investmentTransactionKeys) as $key) {
                $data->$key = $request->$key;
            }

            $data->updated_by = Auth::user()->id;
            $data->updated_at = Carbon::now();
            $data->last_update_ip = request()->ip();
            $data->update();

            return response()->json(['status' => true, 'message' => 'Investment Transaction Create!', 'code' => generateCode("Investment_Transaction", 'TR')], 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function getInvestmentTransaction(Request $request)
    {
        $transactions = InvestmentTransaction::with('investmentAccount', 'addBy');

        if (isset($request->accountId) && $request->accountId != '') {
            $transactions = $transactions->where('investment_account_id', $request->accountId);
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

    public function investmentTransactionDestroy(Request $request)
    {
        try {
            $data = InvestmentTransaction::find($request->id);
            $data->status = 'd';
            $data->last_update_ip = request()->ip();
            $data->deleted_by = Auth::user()->id;
            $data->update();

            $data->delete();
            return response()->json(['status' => true, 'message' => 'Investment Transaction Delete!'], 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function investmentView()
    {
        if (!checkAccess('investmentView')) {
            return view('error.unauthorize');
        }

        $data['investment_transaction_summary'] = InvestmentAccount::investmentTransactionSummary();
        return view('administration.account.investment.view', $data);
    }

    public function investmentTransactionReport()
    {
        if (!checkAccess('investmentTransactionReport')) {
            return view('error.unauthorize');
        }

        return view('administration.account.investment.report');
    }

    public function investmentLedger()
    {
        if (!checkAccess('investmentLedger')) {
            return view('error.unauthorize');
        }

        return view('administration.account.investment.ledger');
    }

    public function getInvestmentLedger(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'accountId' => 'required'
        ], ['accountId.required' => 'Account is required!']);
        if ($validator->fails()) return send_error("Validation Error", $validator->errors(), 422);
        try {
            $ledger = InvestmentTransaction::investmentLedger($request);
            return response()->json($ledger, 200);
        } catch (\Throwable $th) {
            return send_error('Something went worng', $th->getMessage());
        }
    }

    public function getInvestmentTransactionSummary(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'accountId' => 'required'
        ], ['accountId.required' => 'Account is required!']);
        if ($validator->fails()) return send_error("Validation Error", $validator->errors(), 422);
        try {
            $ledger = InvestmentAccount::investmentTransactionSummary($request->accountId);
            return response()->json($ledger, 200);
        } catch (\Throwable $th) {
            return send_error('Something went worng', $th->getMessage());
        }
    }
}
