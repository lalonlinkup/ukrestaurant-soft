<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvestmentAccount extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];


    public static function investmentTransactionSummary($accountId = null, $date = null)
    {
        $investmentTransactionSummary = DB::select("
            select 
                ia.*,
                (
                    select ifnull(sum(it.amount), 0) from investment_transactions it
                    where it.investment_account_id = ia.id
                    and it.type = 'Payment'
                    and it.status = 'a'
                    " . ($date == null ? "" : " and it.date < '$date'") . "
                ) as total_payment,
                (
                    select ifnull(sum(it.amount), 0) from investment_transactions it
                    where it.investment_account_id = ia.id
                    and it.type = 'Receive'
                    and it.status = 'a'
                    " . ($date == null ? "" : " and it.date < '$date'") . "
                ) as total_received,
                (
                    select ifnull(sum(it.amount), 0) from investment_transactions it
                    where it.investment_account_id = ia.id
                    and it.type = 'Profit'
                    and it.status = 'a'
                    " . ($date == null ? "" : " and it.date < '$date'") . "
                ) as total_profit,
                (
                    select (total_received + total_profit) - (total_payment)

                ) as balance

            from investment_accounts ia
            where ia.status = 'a'
            " . ($accountId == null ? "" : " and ia.id = '$accountId'") . "
        ");

        return $investmentTransactionSummary;
    }
}
