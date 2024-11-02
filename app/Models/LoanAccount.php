<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoanAccount extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public static function loanTransactionSummary($accountId = null, $date = null)
    {
        $loanTransactionSummary = DB::select("
            select 
                la.*,
                (
                    select ifnull(sum(lt.amount), 0) from loan_transactions lt
                    where lt.loan_account_id = la.id
                    and lt.type = 'Payment'
                    and lt.status = 'a'
                    " . ($date == null ? "" : " and lt.date < '$date'") . "
                ) as total_payment,
                (
                    select ifnull(sum(lt.amount), 0) from loan_transactions lt
                    where lt.loan_account_id = la.id
                    and lt.type = 'Receive'
                    and lt.status = 'a'
                    " . ($date == null ? "" : " and lt.date < '$date'") . "
                ) as total_received,
                (
                    select ifnull(sum(lt.amount), 0) from loan_transactions lt
                    where lt.loan_account_id = la.id
                    and lt.type = 'Interest'
                    and lt.status = 'a'
                    " . ($date == null ? "" : " and lt.date < '$date'") . "
                ) as total_interest,
                (
                    select (la.initial_balance + total_received + total_interest) - (total_payment)

                ) as balance

            from loan_accounts la
            where la.status = 'a'
            " . ($accountId == null ? "" : " and la.id = '$accountId'") . "
        ");

        return $loanTransactionSummary;
    }
}
