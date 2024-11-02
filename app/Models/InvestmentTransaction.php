<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvestmentTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function investmentAccount()
    {
        return $this->belongsTo(InvestmentAccount::class)->select('id', 'code', 'name');
    }

    public function addBy()
    {
        return $this->belongsTo(User::class, 'added_by', 'id')->select('id', 'name');
    }

    public static function investmentLedger($request)
    {
        $clauses = "";

        if (isset($request->accountId) && $request->accountId != null) {
            $clauses .= " and investment_account_id = '$request->accountId'";
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
                    it.id,
                    it.type as description,
                    it.investment_account_id,
                    it.date,
                    it.type,
                    it.amount as receive,
                    0.00 as payment,
                    0.00 as profit,
                    it.note,
                    ia.code,
                    ia.name,
                    0.00 as balance
                from investment_transactions it
                join investment_accounts ia on ia.id = it.investment_account_id
                where it.status = 'a'
                and it.type = 'Receive'

                UNION
                select 
                    'b' as sequence,
                    it.id,
                    it.type as description,
                    it.investment_account_id,
                    it.date,
                    it.type,
                    0.00 as receive,
                    0.00 as payment,
                    it.amount as profit,
                    it.note,
                    ia.code,
                    ia.name,
                    0.00 as balance
                from investment_transactions it
                join investment_accounts ia on ia.id = it.investment_account_id
                where it.status = 'a'
                and it.type = 'Profit'

                UNION
                select 
                    'c' as sequence,
                    it.id,
                    it.type as description,
                    it.investment_account_id,
                    it.date,
                    it.type,
                    0.00 as receive,
                    it.amount as payment,
                    0.00 as interest,
                    it.note,
                    ia.code,
                    ia.name,
                    0.00 as balance
                from investment_transactions it
                join investment_accounts ia on ia.id = it.investment_account_id
                where it.status = 'a'
                and it.type = 'Payment'

            ) as tbl
            where 1 = 1
            $clauses
            order by date, sequence, id
        ");

        $previousBalance = InvestmentAccount::investmentTransactionSummary($request->accountId, $request->dateFrom)[0]->balance;

        $transactions = array_map(function ($key, $trn) use ($previousBalance, $transactions) {
            $trn->balance = (($key == 0 ? $previousBalance : $transactions[$key - 1]->balance) + $trn->receive + $trn->profit) - $trn->payment;
            return $trn;
        }, array_keys($transactions), $transactions);

        $res['previousBalance'] = $previousBalance;
        $res['transactions'] = $transactions;

        return $res;
    }
}
