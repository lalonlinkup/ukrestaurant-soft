<?php

namespace App\Http\Controllers\Administration;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Asset;
use App\Models\BankAccount;
use App\Models\Customer;
use App\Models\InvestmentAccount;
use App\Models\LoanAccount;
use App\Models\Supplier;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function profitLoss()
    {
        if (!checkAccess('profitLoss')) {
            return view('error.unauthorize');
        }
        return view('administration.reports.profitLoss');
    }

    public function getProfitLoss(Request $request)
    {
        $clauses = "";
        if ($request->customerId != null && $request->customerId != '') {
            $clauses .= " and c.id = '$request->customerId'";
        }
        if (!empty($request->dateFrom) && !empty($request->dateTo)) {
            $clauses .= " and s.date between '$request->dateFrom' and '$request->dateTo'";
        }

        $sales = DB::select("
        select 
            s.*,
            ifnull(c.code, 'Cash') as code,
            ifnull(c.name, s.customer_name) as name,
            ifnull(c.phone, s.customer_phone) as phone
        from sales s
        left join customers c on c.id = s.customer_id
        where s.status = 'a'
        $clauses
    ");

        foreach ($sales as $sale) {
            $sale->saleDetails = DB::select("
            select
                sd.*,
                p.code,
                p.name,
                (sd.purchase_rate * sd.quantity) as purchased_amount,
                (select sd.total - purchased_amount) as profit_loss
            from sale_details sd 
            left join products p on p.id = sd.product_id
            where sd.sale_id = ?
            and sd.status = 'a'
        ", [$sale->id]);
        }

        return response()->json($sales);
    }


    public function getOtherIncomeExpense(Request $request)
    {
        $transactionDateClause = "";
        $employePaymentDateClause = "";
        $profitDistributeDateClause = "";
        $loanInterestDateClause = "";
        $assetsSalesDateClause = "";
        $damageClause = "";
        $returnClause = "";
        $purchaseClause = "";
        if (!empty($request->dateFrom) && !empty($request->dateTo)) {
            $transactionDateClause = " and ct.date between '$request->dateFrom' and '$request->dateTo'";
            $employePaymentDateClause = " and ep.date between '$request->dateFrom' and '$request->dateTo'";
            $profitDistributeDateClause = " and it.date between '$request->dateFrom' and '$request->dateTo'";
            $loanInterestDateClause = " and lt.date between '$request->dateFrom' and '$request->dateTo'";
            $assetsSalesDateClause = " and a.date between '$request->dateFrom' and '$request->dateTo'";
            $damageClause = " and d.date between '$request->dateFrom' and '$request->dateTo'";
            $returnClause = " and r.date between '$request->dateFrom' and '$request->dateTo'";
            $purchaseClause = " and p.date between '$request->dateFrom' and '$request->dateTo'";
        }

        $result = DB::select("
            select
            (
                select ifnull(sum(ct.in_amount), 0)
                from cash_transactions ct
                where ct.status = 'a'
                $transactionDateClause
            ) as income,
        
            (
                select ifnull(sum(ct.out_amount), 0)
                from cash_transactions ct
                where ct.status = 'a'
                $transactionDateClause
            ) as expense,
        
            (
                select ifnull(sum(ep.amount), 0)
                from employee_payments ep
                where ep.status = 'a'
                $employePaymentDateClause
            ) as employee_payment,

            (
                select ifnull(sum(it.amount), 0)
                from investment_transactions it
                where it.type = 'Profit'
                and it.status = 'a'
                $profitDistributeDateClause
            ) as profit_distribute,

            (
                select ifnull(sum(lt.amount), 0)
                from loan_transactions lt
                where lt.type = 'Interest'
                and lt.status = 'a'
                $loanInterestDateClause
            ) as loan_interest,

            (
                select ifnull(sum(p.discountAmount), 0) 
                from purchases p
                where p.status = 'a'
                $purchaseClause
            ) as purchase_discount,
            
            (
                select ifnull(sum(p.vatAmount), 0) 
                from purchases p
                where p.status = 'a'
                $purchaseClause
            ) as purchase_vat
        ");

        return response()->json($result);
    }

    // balance-sheet
    public function balanceSheet()
    {
        return view('administration.reports.balancesheet');
    }

    public function getbalanceSheet(Request $request)
    {
        try {

            $date = null;

            if (!empty($request->date)) {
                $date = Carbon::parse($request->date);
                $date = $date->addDays(1)->format('Y-m-d');
            }

            $cash_balance = Account::cashTransactionSummary($date)[0]->cash_balance;
            $bank_accounts = BankAccount::bankTransactionSummary(null, $date);
            $loan_accounts = LoanAccount::loanTransactionSummary(null, $date);
            $invest_accounts = InvestmentAccount::investmentTransactionSummary(null, $date);

            //customer prev due adjust
            $customer_prev_due = DB::select("
            SELECT ifnull(sum(previous_due), 0) as amount
            from customers
            ")[0]->amount;

            //customer dues
            $customer_dues = Customer::customerDue(" and c.status = 'a'", $date);
            $bad_debts = Customer::customerDue(" and c.status = 'd'", $date);

            $customer_dues = array_reduce($customer_dues, function ($prev, $curr) {
                return $prev + $curr->dueAmount;
            });

            $bad_debts = array_reduce($bad_debts, function ($prev, $curr) {
                return $prev + $curr->dueAmount;
            });

            //supplier prev due adjust
            $supplier_prev_due = DB::select("
                SELECT ifnull(sum(previous_due), 0) as amount
                from suppliers
            ")[0]->amount;

            //supplier due
            $supplier_dues = Supplier::supplierDue(['date' => $date]);

            $supplier_dues = array_reduce($supplier_dues, function ($prev, $curr) {
                return $prev + $curr->due;
            }, 0);


            $other_income_expense = DB::select("
                select 
                (
                    select ifnull(sum(ct.in_amount), 0)
                    from cash_transactions ct
                    where ct.status = 'a'
                    " . ($date == null ? "" : " and ct.date < '$date'") . "
                ) as income,
            
                (
                    select ifnull(sum(ct.out_amount), 0)
                    from cash_transactions ct
                    where ct.status = 'a'
                    " . ($date == null ? "" : " and ct.date < '$date'") . "
                ) as expense,

                (
                    select ifnull(sum(it.amount), 0)
                    from investment_transactions it
                    where it.type = 'Profit'
                    and it.status = 'a'
                    " . ($date == null ? "" : " and it.date < '$date'") . "
                ) as profit_distribute,

                (
                    select ifnull(sum(lt.amount), 0)
                    from loan_transactions lt
                    where lt.type = 'Interest'
                    and lt.status = 'a'
                    " . ($date == null ? "" : " and lt.date < '$date'") . "
                ) as loan_interest,

                (
                    select ifnull(sum(pm.discountAmount), 0) 
                    from purchases pm
                    where pm.status = 'a'
                    " . ($date == null ? "" : " and pm.date < '$date'") . "
                ) as purchase_discount,
                
                (
                    select ifnull(sum(pm.vatAmount), 0) 
                    from purchases pm
                    where pm.status = 'a'
                    " . ($date == null ? "" : " and pm.date < '$date'") . "
                ) as purchase_vat,
            
                (
                    select ifnull(sum(ep.amount), 0)
                    from employee_payments ep
                    where ep.status = 'a'
                    " . ($date == null ? "" : " and ep.date < '$date'") . "
                ) as employee_payment
            ")[0];

            $net_profit = (
                $other_income_expense->income +
                $other_income_expense->purchase_discount
            ) - (
                $other_income_expense->expense +
                $other_income_expense->employee_payment +
                $other_income_expense->profit_distribute +
                $other_income_expense->loan_interest +
                $other_income_expense->purchase_vat
            );



            $statements = [
                'cash_balance'          => $cash_balance,
                'bank_accounts'         => $bank_accounts,
                'loan_accounts'         => $loan_accounts,
                'invest_accounts'       => $invest_accounts,
                'customer_dues'         => $customer_dues,
                'supplier_dues'         => $supplier_dues,
                'bad_debts'             => $bad_debts,
                'supplier_prev_due'     => $supplier_prev_due,
                'customer_prev_due'     => $customer_prev_due,
                'net_profit'            => $net_profit,
            ];
            return response()->json($statements, 200);
        } catch (\Throwable $th) {
            return send_error('Something went wrong', $th->getMessage());
        }
    }
    // balance-inout
    public function balanceInOut()
    {
        return view('administration.reports.balanceinoutsheet');
    }
    // day book
    public function dayBook()
    {
        return view('administration.reports.daybook');
    }

    public function getCashAndBankBalance(Request $request)
    {
        try {
            $date = null;
            if (isset($request->date) && $request->date != '') {
                $date = $request->date;
            }

            $res['cashBalance'] = Account::cashTransactionSummary($date)[0];

            $res['bankBalance'] = BankAccount::bankTransactionSummary(null, $date);

            return response()->json($res, 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }
}
