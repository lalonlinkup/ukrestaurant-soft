<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class BankAccount extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'number',
        'type',
        'bank_name',
        'branch_name',
    ];


    public static function bankTransactionSummary($bankId = null, $date = null)
    {
        $bankTransactionSummary = DB::select("
            select 
                ba.*,
                (
                    select ifnull(sum(bt.amount), 0) from bank_transactions bt
                    where bt.bank_account_id = ba.id
                    and bt.type = 'deposit'
                    and bt.status = 'a'
                    " . ($date == null ? "" : " and bt.date < '$date'") . "
                ) as total_deposit,
                (
                    select ifnull(sum(bt.amount), 0) from bank_transactions bt
                    where bt.bank_account_id = ba.id
                    and bt.type = 'withdraw'
                    and bt.status = 'a'
                    " . ($date == null ? "" : " and bt.date < '$date'") . "
                ) as total_withdraw,
                (
                    select ifnull(sum(cp.amount), 0) from customer_payments cp
                    where cp.bank_account_id = ba.id
                    and cp.status = 'a'
                    and cp.type = 'CR'
                    " . ($date == null ? "" : " and cp.date < '$date'") . "
                ) as total_received_from_customer,
                (
                    select ifnull(sum(cp.amount), 0) from customer_payments cp
                    where cp.bank_account_id = ba.id
                    and cp.status = 'a'
                    and cp.type = 'CP'
                    " . ($date == null ? "" : " and cp.date < '$date'") . "
                ) as total_paid_to_customer,
                (
                    select ifnull(sum(sp.amount), 0) from supplier_payments sp
                    where sp.bank_account_id = ba.id
                    and sp.status = 'a'
                    and sp.type = 'CP'
                    " . ($date == null ? "" : " and sp.date < '$date'") . "
                ) as total_paid_to_supplier,
                (
                    select ifnull(sum(sp.amount), 0) from supplier_payments sp
                    where sp.bank_account_id = ba.id
                    and sp.status = 'a'
                    and sp.type = 'CR'
                    " . ($date == null ? "" : " and sp.date < '$date'") . "
                ) as total_received_from_supplier,
                (
                    select (ba.initial_balance + total_deposit + total_received_from_customer + total_received_from_supplier) - (total_withdraw + total_paid_to_customer + total_paid_to_supplier)
                ) as balance
            from bank_accounts ba
            where ba.status = 'a'
            " . ($bankId == null ? "" : " and ba.id = '$bankId'") . "
        ");

        return $bankTransactionSummary;
    }

    public static function bankLedger($request)
    {
        try {
            $request = (object) $request;
            $clauses = "";

            if (!empty($request->bankId)) {
                $clauses .= " and bank_account_id = '$request->bankId'";
            }

            if (!empty($request->dateFrom) && !empty($request->dateTo)) {
                $clauses .= " and date between '$request->dateFrom' and '$request->dateTo'";
            }

            if (!empty($request->type)) {
                $clauses .= " and type = '$request->type'";
            }

            $ledger = DB::select("
            select * from(
                select 
                    'a' as sequence,
                    bt.id as id,
                    bt.type as description,
                    bt.bank_account_id,
                    bt.date,
                    bt.type,
                    bt.amount as deposit,
                    0.00 as withdraw,
                    bt.note,
                    ba.name,
                    ba.number,
                    ba.bank_name,
                    ba.branch_name,
                    0.00 as balance
                from bank_transactions bt
                join bank_accounts ba on ba.id = bt.bank_account_id
                where bt.status = 'a'
                and bt.type = 'deposit'

                UNION
                select 
                    'b' as sequence,
                    bt.id as id,
                    bt.type as description,
                    bt.bank_account_id,
                    bt.date,
                    bt.type,
                    0.00 as deposit,
                    bt.amount as withdraw,
                    bt.note,
                    ba.name,
                    ba.number,
                    ba.bank_name,
                    ba.branch_name,
                    0.00 as balance
                from bank_transactions bt
                join bank_accounts ba on ba.id = bt.bank_account_id
                where bt.status = 'a'
                and bt.type = 'withdraw'
                
                UNION
                select
                    'c' as sequence,
                    cp.id as id,
                    concat('Payment Received - ', c.name, ' (', c.code, ')') as description, 
                    cp.bank_account_id,
                    cp.date as date,
                    'deposit' as type,
                    cp.amount as deposit,
                    0.00 as withdraw,
                    cp.note,
                    ba.name,
                    ba.number,
                    ba.bank_name,
                    ba.branch_name,
                    0.00 as balance
                from customer_payments cp
                join bank_accounts ba on ba.id = cp.bank_account_id
                join customers c on c.id = cp.customer_id
                where cp.bank_account_id is not null
                and cp.status = 'a'
                and cp.type = 'CR'
                
                UNION
                select
                    'd' as sequence,
                    cp.id as id,
                    concat('paid to Guest - ', c.name, ' (', c.code, ')') as description, 
                    cp.bank_account_id,
                    cp.date as date,
                    'withdraw' as type,
                    0.00 as deposit,
                    cp.amount as withdraw,
                    cp.note,
                    ba.name,
                    ba.number,
                    ba.bank_name,
                    ba.branch_name,
                    0.00 as balance
                from customer_payments cp
                join bank_accounts ba on ba.id = cp.bank_account_id
                join customers c on c.id = cp.customer_id
                where cp.bank_account_id is not null
                and cp.status = 'a'
                and cp.type = 'CP'
                
                UNION
                select 
                    'e' as sequence,
                    sp.id as id,
                    concat('paid - ', s.name, ' (', s.code, ')') as description, 
                    sp.bank_account_id,
                    sp.date as date,
                    'withdraw' as type,
                    0.00 as deposit,
                    sp.amount as withdraw,
                    sp.note,
                    ba.name,
                    ba.number,
                    ba.bank_name,
                    ba.branch_name,
                    0.00 as balance
                from supplier_payments sp
                join bank_accounts ba on ba.id = sp.bank_account_id
                join suppliers s on s.id = sp.supplier_id
                where sp.bank_account_id is not null
                and sp.status = 'a'
                and sp.type = 'CP'
                
                UNION
                select 
                    'f' as sequence,
                    sp.id as id,
                    concat('received from supplier - ', s.name, ' (', s.code, ')') as description, 
                    sp.bank_account_id,
                    sp.date as date,
                    'deposit' as type,
                    sp.amount as deposit,
                    0.00 as withdraw,
                    sp.note,
                    ba.name,
                    ba.number,
                    ba.bank_name,
                    ba.branch_name,
                    0.00 as balance
                from supplier_payments sp
                join bank_accounts ba on ba.id = sp.bank_account_id
                join suppliers s on s.id = sp.supplier_id
                where sp.bank_account_id is not null
                and sp.status = 'a'
                and sp.type = 'CR'
            ) as tbl
            where 'a' = 'a' $clauses
            order by sequence, id asc
        ");

            if (!empty($request->for)) {
                return $ledger;
            }
            $previousBalance = self::bankTransactionSummary($request->bankId, $request->dateFrom)[0]->balance;

            $ledger = array_map(function ($key, $trn) use ($previousBalance, $ledger) {
                $trn->balance = (($key == 0 ? $previousBalance : $ledger[$key - 1]->balance) + $trn->deposit) - $trn->withdraw;
                return $trn;
            }, array_keys($ledger), $ledger);

            $res['previousBalance'] = $previousBalance;
            $res['ledgers'] = $ledger;
            return $res;
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }
}
