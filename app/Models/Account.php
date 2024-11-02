<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Account extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'name'
    ];


    public static function cashTransactionSummary($date = null)
    {
        $transactionSummary = DB::select("
            select
            /* Received */
            (
                select ifnull(sum(bkm.advance), 0) from booking_masters bkm
                where bkm.status = 'a'
                and bkm.advance > 0
                " . ($date == null ? "" : " and bkm.date < '$date'") . "
            ) as received_booking,
            (
                select ifnull(sum(cp.amount), 0) from customer_payments cp
                where cp.type = 'CR'
                and cp.status = 'a'
                and cp.method = 'cash'
                " . ($date == null ? "" : " and cp.date < '$date'") . "
            ) as received_customer,
            (
                select ifnull(sum(ct.in_amount), 0) from cash_transactions ct
                where ct.type = 'In Cash'
                and ct.status = 'a'
                " . ($date == null ? "" : " and ct.date < '$date'") . "
            ) as received_cash,
            (
                select ifnull(sum(bt.amount), 0) from bank_transactions bt
                where bt.type = 'withdraw'
                and bt.status = 'a'
                " . ($date == null ? "" : " and bt.date < '$date'") . "
            ) as bank_withdraw,
            (
                select ifnull(sum(bt.amount), 0) from loan_transactions bt
                where bt.type = 'Receive'
                and bt.status = 'a'
                " . ($date == null ? "" : " and bt.date < '$date'") . "
            ) as loan_received,
            (
                select ifnull(sum(la.initial_balance), 0) from loan_accounts la
                where la.status = 'a'
                " . ($date == null ? "" : " and DATE_FORMAT(la.created_at, '%Y-%m-%d') < '$date'") . "
            ) as loan_initial_balance,
            (
                select ifnull(sum(bt.amount), 0) from investment_transactions bt
                where bt.type = 'Receive'
                and bt.status = 'a'
                " . ($date == null ? "" : " and bt.date < '$date'") . "
            ) as invest_received,

            /* paid */
            (
                select ifnull(sum(cp.amount), 0) from customer_payments cp
                where cp.type = 'CP'
                and cp.status = 'a'
                and cp.method != 'bank'
                " . ($date == null ? "" : " and cp.date < '$date'") . "
            ) as paid_customer,
            (
                select ifnull(sum(ct.Out_Amount), 0) from cash_transactions ct
                where ct.type = 'Out Cash'
                and ct.status = 'a'
                " . ($date == null ? "" : " and ct.date < '$date'") . "
            ) as paid_cash,
            (
                select ifnull(sum(bt.amount), 0) from bank_transactions bt
                where bt.type = 'deposit'
                and bt.status = 'a'
                " . ($date == null ? "" : " and bt.date < '$date'") . "
            ) as bank_deposit,
            (
                select ifnull(sum(bt.amount), 0) from loan_transactions bt
                where bt.type = 'Payment'
                and bt.status = 'a'
                " . ($date == null ? "" : " and bt.date < '$date'") . "
            ) as loan_payment,
            (
                select ifnull(sum(bt.amount), 0) from investment_transactions bt
                where bt.type = 'Payment'
                and bt.status = 'a'
                " . ($date == null ? "" : " and bt.date < '$date'") . "
            ) as invest_payment,
            (
                select ifnull(sum(ep.amount), 0) from employee_payments ep
                where ep.status = 'a'
                " . ($date == null ? "" : " and ep.date < '$date'") . "
            ) as employee_payment,
            /* total */
            (select received_booking + received_customer  + received_cash + bank_withdraw + loan_received + loan_initial_balance + invest_received) as total_in,
            (select paid_customer + paid_cash + bank_deposit + employee_payment + loan_payment + invest_payment) as total_out,
            (select total_in - total_out) as cash_balance
        ");

        return $transactionSummary;
    }


    public static function cashLedger($request)
    {
        $request = (object)$request;
        try {
            $previousBalance = self::cashTransactionSummary($request->dateFrom)[0]->cash_balance;

            $ledger = DB::select("
                /* Cash In */
                select 
                    sm.id as id,
                    sm.date as date,
                    concat('Booking - ', sm.invoice, ' - ', ifnull(c.name, 'Cash Guest'), ' (', ifnull(c.code, ''), ')', ' - Bill: ', sm.total) as description,
                    sm.advance as in_amount,
                    0.00 as out_amount
                from booking_masters sm 
                left join customers c on c.id = sm.customer_id
                where sm.status = 'a'
                and sm.date between '$request->dateFrom' and '$request->dateTo'
                
                UNION
                
                select 
                    cp.id as id,
                    cp.date as date,
                    concat('Due collection - ', cp.invoice, ' - ', c.name, ' (', c.code, ')') as description,
                    cp.amount as in_amount,
                    0.00 as out_amount
                from customer_payments cp
                join customers c on c.id = cp.customer_id
                where cp.status = 'a'
                and cp.type = 'CR'
                and cp.method = 'cash'
                and cp.date between '$request->dateFrom' and '$request->dateTo'
                
                UNION
                
                select 
                    sp.id as id,
                    sp.date as date,
                    concat('Received from supplier - ', sp.invoice, ' - ', s.name, ' (', s.code, ')') as description,
                    sp.amount as in_amount,
                    0.00 as out_amount
                from supplier_payments sp
                join suppliers s on s.id = sp.supplier_id
                where sp.type = 'CR'
                and sp.status = 'a'
                and sp.method = 'cash'
                and sp.date between '$request->dateFrom' and '$request->dateTo'
                
                UNION
                
                select 
                    ct.id as id,
                    ct.date as date,
                    concat('Cash in - ', acc.name) as description,
                    ct.in_amount as in_amount,
                    0.00 as out_amount
                from cash_transactions ct
                join accounts acc on acc.id = ct.account_id
                where ct.status = 'a'
                and ct.type = 'In Cash'
                and ct.date between '$request->dateFrom' and '$request->dateTo'
                
                UNION
                
                select 
                    bt.id as id,
                    bt.date as date,
                    concat('Bank withdraw - ', ba.bank_name, ' - ', ba.branch_name, ' - ', ba.name, ' - ', ba.number) as description,
                    bt.amount as in_amount,
                    0.00 as out_amount
                from bank_transactions bt 
                join bank_accounts ba on ba.id = bt.bank_account_id
                where bt.status = 'a'
                and bt.type = 'withdraw'
                and bt.date between '$request->dateFrom' and '$request->dateTo'
                
                UNION
                
                select 
                    lt.id as id,
                    lt.date as date,
                    concat('Loan Received - ', ba.bank_name, ' - ', ba.name, ' - ', ba.number) as description,
                    lt.amount as in_amount,
                    0.00 as out_amount
                from loan_transactions lt 
                join loan_accounts ba on ba.id = lt.loan_account_id
                where lt.status = 'a'
                and lt.type = 'Receive'
                and lt.date between '$request->dateFrom' and '$request->dateTo'
                
                UNION

                select 
                    la.id as id,
                    DATE_FORMAT(la.created_at, '%Y-%m-%d') as date,
                    concat('Loan Initial Balance - ', la.bank_name, ' - ', la.name, ' - ', la.number) as description,
                    la.initial_balance as in_amount,
                    0.00 as out_amount
                from loan_accounts la
                where DATE_FORMAT(la.created_at, '%Y-%m-%d') between '$request->dateFrom' and '$request->dateTo'
                
                UNION
                                
                select 
                    ivt.id as id,
                    ivt.date as date,
                    concat('Invest Received - ', ia.name, ' (', ia.code, ')') as description,
                    ivt.amount as in_amount,
                    0.00 as out_amount
                from investment_transactions ivt 
                join investment_accounts ia on ia.id = ivt.investment_account_id
                where ivt.status = 'a'
                and ivt.type = 'Receive'
                and ivt.date between '$request->dateFrom' and '$request->dateTo'            
                
                /* Cash out */
                
                UNION
                
                select 
                    pm.id as id,
                    pm.date as date,
                    concat('Purchase - ', pm.invoice, ' - ', ifnull(s.name, 'Cash Supplier'), ' (', ifnull(s.code, ''), ')', ' - Bill: ', pm.total) as description,
                    0.00 as in_amount,
                    pm.paid as out_amount
                from purchases pm 
                left join suppliers s on s.id = pm.supplier_id
                where pm.status = 'a'
                and pm.date between '$request->dateFrom' and '$request->dateTo'

                UNION
            
                select 
                    mp.id as id,
                    mp.date as date,
                    concat('Material Purchase - ', mp.invoice, ' - ', ifnull(s.name, 'Cash Supplier'), ' (', ifnull(s.name, ''), ')', ' - Bill: ', mp.total) as description,
                    0.00 as in_amount,
                    mp.paid as out_amount
                from material_purchases mp
                left join suppliers s on s.id = mp.supplier_id
                where mp.status = 'a'
                and mp.date between '$request->dateFrom' and '$request->dateTo'
                
                UNION
                
                select 
                    sp.id as id,
                    sp.date as date,
                    concat('Supplier payment - ', sp.invoice, ' - ', s.name, ' (', s.code, ')') as description,
                    0.00 as in_amount,
                    sp.amount as out_amount
                from supplier_payments sp 
                join suppliers s on s.id = sp.supplier_id
                where sp.type = 'CP'
                and sp.status = 'a'
                and sp.method = 'cash'
                and sp.date between '$request->dateFrom' and '$request->dateTo'
                
                UNION
                
                select 
                    cp.id as id,
                    cp.date as date,
                    concat('Paid to Guest - ', cp.invoice, ' - ', c.name, '(', c.name, ')') as description,
                    0.00 as in_amount,
                    cp.amount as out_amount
                from customer_payments cp
                join customers c on c.id = cp.customer_id
                where cp.type = 'CP'
                and cp.status = 'a'
                and cp.method = 'cash'
                and cp.date between '$request->dateFrom' and '$request->dateTo'
                
                UNION
                
                select 
                    ct.id as id,
                    ct.date as date,
                    concat('Cash out - ', acc.name) as description,
                    0.00 as in_cash,
                    ct.out_amount as out_amount
                from cash_transactions ct
                join accounts acc on acc.id = ct.account_id
                where ct.type = 'Out Cash'
                and ct.status = 'a'
                and ct.date between '$request->dateFrom' and '$request->dateTo'
                
                UNION
                
                select 
                    bt.id as id,
                    bt.date as date,
                    concat('Bank deposit - ', ba.bank_name, ' - ', ba.branch_name, ' - ', ba.name, ' - ', ba.number) as description,
                    0.00 as in_amount,
                    bt.amount as out_amount
                from bank_transactions bt
                join bank_accounts ba on ba.id = bt.bank_account_id
                where bt.type = 'deposit'
                and bt.status = 'a'
                and bt.date between '$request->dateFrom' and '$request->dateTo'
    
                UNION
                
                select 
                    ep.id as id,
                    ep.date as date,
                    concat('Employee salary - ', ep.month) as description,
                    0.00 as in_amount,
                    ep.amount as out_amount
                from employee_payments ep
                where ep.status = 'a'
                and ep.date between '$request->dateFrom' and '$request->dateTo'
                
                UNION
                
                select 
                    lt.id as id,
                    lt.date as date,
                    concat('Loan Payment - ', la.bank_name, ' - ', la.name, ' - ', la.number) as description,
                    0.00 as in_amount,
                    lt.amount as out_amount
                from loan_transactions lt
                join loan_accounts la on la.id = lt.loan_account_id
                where lt.type = 'Payment'
                and lt.status = 'a'
                and lt.date between '$request->dateFrom' and '$request->dateTo'
    
                UNION
                
                select 
                    ivt.id as id,
                    ivt.date as date,
                    concat('Invest Payment - ', iva.name, ' (', iva.code, ')') as description,
                    0.00 as in_amount,
                    ivt.amount as out_amount
                from investment_transactions ivt 
                join investment_accounts iva on iva.id = ivt.investment_account_id
                where ivt.status = 'a'
                and ivt.type = 'Payment'
                and ivt.date between '$request->dateFrom' and '$request->dateTo'
                    
                order by date, id asc
            ");

            $ledger = array_map(function ($ind, $row) use ($previousBalance, $ledger) {
                $row->balance = (($ind == 0 ? $previousBalance : $ledger[$ind - 1]->balance) + $row->in_amount) - $row->out_amount;
                return $row;
            }, array_keys($ledger), $ledger);

            $res['previousBalance'] = $previousBalance;
            $res['ledgers'] = $ledger;

            return $res;
        } catch (\Throwable $th) {
            return send_error("something went wrong", $th->getMessage());
        }
    }
}
