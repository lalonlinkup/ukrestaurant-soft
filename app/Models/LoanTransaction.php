<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoanTransaction extends Model
{
    use HasFactory, SoftDeletes;

    public function loanAccount()
    {
        return $this->belongsTo(LoanAccount::class)->select('id', 'name', 'number', 'bank_name', 'branch_name');;
    }

    public function addBy()
    {
        return $this->belongsTo(User::class, 'added_by', 'id')->select('id', 'name');
    }

    public static function loanLedger($request)
    {
        $request = (object)$request;
        $clauses = "";

        if (isset($request->accountId) && $request->accountId != null) {
            $clauses .= " and loan_account_id = '$request->accountId'";
        }

        if (isset($request->dateFrom) && $request->dateFrom != '' && isset($request->dateTo) && $request->dateTo != '') {
            $clauses .= " and date between '$request->dateFrom' and '$request->dateTo'";
        }

        if (isset($request->type) && $request->type != '') {
            $clauses .= " and type = '$request->type'";
        }

        $transactions = DB::select("
            select * from(
                select 
                    'a' as sequence,
                    lt.id,
                    lt.type as description,
                    lt.loan_account_id,
                    lt.date,
                    lt.type,
                    lt.amount as receive,
                    0.00 as payment,
                    0.00 as interest,
                    lt.note,
                    la.name as account_name,
                    la.number as account_number,
                    la.bank_name,
                    la.branch_name,
                    0.00 as balance
                from loan_transactions lt
                join loan_accounts la on la.id = lt.loan_account_id
                where lt.status = 'a'
                and lt.type = 'Receive'

                UNION
                select 
                    'b' as sequence,
                    lt.id,
                    lt.type as description,
                    lt.loan_account_id,
                    lt.date,
                    lt.type,
                    0.00 as receive,
                    0.00 as payment,
                    lt.amount as interest,
                    lt.note,
                    la.name as account_name,
                    la.number as account_number,
                    la.bank_name,
                    la.branch_name,
                    0.00 as balance
                from loan_transactions lt
                join loan_accounts la on la.id = lt.loan_account_id
                where lt.status = 'a'
                and lt.type = 'Interest'

                UNION
                select 
                    'c' as sequence,
                    lt.id,
                    lt.type as description,
                    lt.loan_account_id,
                    lt.date,
                    lt.type,
                    0.00 as receive,
                    lt.amount as payment,
                    0.00 as interest,
                    lt.note,
                    la.name as account_name,
                    la.number as account_number,
                    la.bank_name,
                    la.branch_name,
                    0.00 as balance
                from loan_transactions lt
                join loan_accounts la on la.id = lt.loan_account_id
                where lt.status = 'a'
                and lt.type = 'Payment'

            ) as tbl
            where 1 = 1 $clauses
            order by date, sequence, id
        ");

        $previousBalance = LoanAccount::loanTransactionSummary($request->accountId, $request->dateFrom)[0]->balance;

        $transactions = array_map(function ($key, $trn) use ($previousBalance, $transactions) {
            $trn->balance = (($key == 0 ? $previousBalance : $transactions[$key - 1]->balance) + $trn->receive + $trn->interest) - $trn->payment;
            return $trn;
        }, array_keys($transactions), $transactions);

        $res['previousBalance'] = $previousBalance;
        $res['transactions'] = $transactions;

        return $res;
    }
}
