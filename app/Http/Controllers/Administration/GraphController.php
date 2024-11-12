<?php

namespace App\Http\Controllers\Administration;

use App\Models\Account;
use App\Models\Customer;
use App\Models\BankAccount;
use App\Models\LoanAccount;
use Illuminate\Http\Request;
use App\Models\InvestmentAccount;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class GraphController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        if (!checkAccess('graph')) {
            return view('error.unauthorize');
        }

        return view('administration.graph.index');
    }

    public function index()
    {
        try {
            $year = date('Y');
            $month = date('m');
            $today = date('Y-m-d');

            // total table
            $totalTable = DB::select("
                    select count(*) as total_table
                    from tables t
                    where t.status = 'a'
                ")[0]->total_table;

            // total booked table
            $totalBookedTable = DB::select("
                    select count(*) as total_booked_table
                    from tables t
                    where t.status = 'a'
                    and t.id in (select ot.table_id from orders ot where ot.status = 'p')
                ")[0]->total_booked_table;

            // total available table
            $totalAvailableTable = DB::select("
                    select count(*) as total_available_table
                    from tables t
                    where t.status = 'a'
                    and t.id not in (select ot.table_id from orders ot where ot.status = 'p')
                ")[0]->total_available_table;

            // checkin list
            $checkin_date = date('Y-m-d') . ' 12:00:00';
            $tables = DB::select("select r.*,
                                rt.name as tabletype_name
                                from tables r
                                left join table_types rt on rt.id = r.table_type_id
                                where r.status != 'd' and r.deleted_at is null
                                ");

            foreach ($tables as $key => $item) {
                $tableavailable = DB::select("select * from tables rm where rm.id not in (select bkd.table_id from booking_details bkd where bkd.status = 'a' and '$checkin_date' between bkd.checkin_date and bkd.checkout_date) and rm.id = ?", [$item->id]);
                $item->available = count($tableavailable) > 0 ? 'true' : 'false';
                $tablebooked = DB::select("select * from tables rm where rm.id in (select bkd.table_id from booking_details bkd where bkd.status = 'a' and bkd.booking_status = 'booked' and '$checkin_date' between bkd.checkin_date and bkd.checkout_date) and rm.id = ?", [$item->id]);
                $item->booked = count($tablebooked) > 0 ? 'true' : 'false';
                $tablecheckin = DB::select("select * from tables rm where rm.id in (select bkd.table_id from booking_details bkd where bkd.status = 'a' and bkd.booking_status = 'checkin' and '$checkin_date' between bkd.checkin_date and bkd.checkout_date) and rm.id = ?", [$item->id]);
                $item->checkin = count($tablecheckin) > 0 ? 'true' : 'false';

                if ($item->available == 'true') {
                    $item->color = "#aee2ff";
                } else if ($item->booked == 'true') {
                    $item->color = '#fffcb2';
                } else if ($item->checkin == 'true') {
                    $item->color = '#ff0000ab';
                }
            }

            $checkIn = count(array_values(array_filter($tables, function ($item) {
                return $item->checkin == 'true';
            })));

            $vacant = count(array_values(array_filter($tables, function ($item) {
                return $item->available == 'true';
            })));

            $todayOrder = DB::select("select count(*) as today_order from orders o where o.status != 'd' and DATE_FORMAT(o.date, '%Y-%m-%d') = ?", [$today])[0]->today_order;

            $totalEmployee = DB::select("select count(*) as employee from employees bkd where bkd.status != 'd'", [$today])[0]->employee;

            // Bank balance
            $bankTransactions = BankAccount::bankTransactionSummary();
            $bankBalance = array_sum(array_map(function ($bank) {
                return $bank->balance;
            }, $bankTransactions));

            // Invest balance
            $investBalance = 0;
            $investTransactions = InvestmentAccount::investmentTransactionSummary();
            $investBalance = array_sum(array_map(function ($bank) {
                return $bank->balance;
            }, $investTransactions));

            // Loan balance
            $loanTransactions =  LoanAccount::loanTransactionSummary();
            $loanBalance = array_sum(array_map(function ($bank) {
                return $bank->balance;
            }, $loanTransactions));

            // Guest Due
            $customerDueResult = Customer::customerDue("");
            $customerDue = array_sum(array_map(function ($due) {
                return $due->dueAmount;
            }, $customerDueResult));

            //expense
            $expense = DB::select("SELECT 
                ifnull(sum(ct.out_amount), 0) as expense 
            FROM cash_transactions ct 
            WHERE ct.status = 'a'")[0]->expense;

            // Today's Cash Collection
            $todaysCollection = DB::select("
                    select
                    ifnull((
                        select sum(ifnull(bkm.paid, 0)) 
                        from orders bkm
                        where bkm.status = 'a'
                        and bkm.date = '" . date('Y-m-d') . "'
                    ), 0) +
                    ifnull((
                        select sum(ifnull(cp.amount, 0)) 
                        from customer_payments cp
                        where cp.status = 'a'
                        and cp.type = 'CR'
                        and cp.date = '" . date('Y-m-d') . "'
                    ), 0) +
                    ifnull((
                        select sum(ifnull(ct.in_amount, 0)) 
                        from cash_transactions ct
                        where ct.status = 'a'
                        and ct.type = 'In Cash'
                        and ct.date = '" . date('Y-m-d') . "'
                    ), 0) as total_amount
                ")[0]->total_amount;
            // Monthly Cash Collection
            $monthlyCollection = DB::select("
                    select
                    ifnull((
                        select sum(ifnull(bkm.paid, 0)) 
                        from orders bkm
                        where bkm.status = 'a'
                        and DATE_FORMAT(bkm.date, '%m') = '" . $month . "'
                    ), 0) +
                    ifnull((
                        select sum(ifnull(cp.amount, 0)) 
                        from customer_payments cp
                        where cp.status = 'a'
                        and cp.type = 'CR'
                        and DATE_FORMAT(cp.date, '%m') = '" . $month . "'
                    ), 0) +
                    ifnull((
                        select sum(ifnull(ct.in_amount, 0)) 
                        from cash_transactions ct
                        where ct.status = 'a'
                        and ct.type = 'In Cash'
                        and DATE_FORMAT(ct.date, '%m') = '" . $month . "'
                    ), 0) as total_amount
                ")[0]->total_amount;

            // Cash Balance
            $cashBalance =  Account::cashTransactionSummary()[0]->cash_balance;
            $responseData = [
                'total_table'           => $totalTable,
                'total_booked_table'    => $totalBookedTable,
                'total_available_table' => $totalAvailableTable,
                'checkIn'               => $checkIn,
                'vacant'                => $vacant,
                'today_order'           => $todayOrder,
                'invest_balance'        => $investBalance,
                'loan_balance'          => $loanBalance,
                'today_collection'      => $todaysCollection,
                'monthly_collection'    => $monthlyCollection,
                'cash_balance'          => $cashBalance,
                'bank_balance'          => $bankBalance,
                'due_amount'            => $customerDue,
                'total_employee'        => $totalEmployee,
                'expense'               => $expense,
                // 'this_month_profit' => $net_profit,
            ];

            return response()->json($responseData, 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function graph(Request $request)
    {
        try {

            // Monthly Record
            $monthlyRecord = [];
            $year = explode('-', $request->year)[0];
            $month = explode('-', $request->year)[1];
            $dayNumber = date('t', mktime(0, 0, 0, $month, 1, $year));

            for ($i = 1; $i <= $dayNumber; $i++) {
                $date = $year . '-' . $month . '-' . sprintf("%02d", $i);
                $query = DB::select("select sum(receivedAmount) as totalReceived from (select
                                        bkm.date as date,
                                        ifnull(sum(bkm.paid), 0) as receivedAmount
                                        from orders bkm 
                                        where bkm.status = 'a'
                                        and bkm.date = '$date'
                                        UNION
                                        select
                                        crp.date as date,
                                        ifnull(sum(crp.amount), 0) as receivedAmount
                                        from customer_payments crp
                                        where crp.status = 'a'
                                        and crp.type = 'CR'
                                        and crp.date = '$date'
                                        UNION
                                        select
                                        ct.date,
                                        ifnull(sum(ct.in_amount), 0) as receivedAmount
                                        from cash_transactions ct
                                        where ct.status = 'a'
                                        and ct.type = 'In Cash'
                                        and ct.date = '$date') as tbl
                                        where date is not null
                                        group by date");

                $amount = 0.00;

                if (count($query) == 0) {
                    $amount = 0.00;
                } else {
                    $amount = $query[0]->totalReceived;
                }
                $collection = [sprintf("%02d", $i), floatval(number_format($amount, 2, '.', ''))];
                array_push($monthlyRecord, $collection);
            }


            $yearlyRecord = [];
            for ($i = 1; $i <= 12; $i++) {
                $yearMonth = $year . sprintf("%02d", $i);
                $query = DB::select("select sum(receivedAmount) as totalReceived from (select
                                        bkm.date as date,
                                        ifnull(sum(bkm.paid), 0) as receivedAmount
                                        from orders bkm 
                                        where bkm.status = 'a'
                                        and extract(year_month from bkm.date) = '$yearMonth'
                                        UNION
                                        select
                                        crp.date as date,
                                        ifnull(sum(crp.amount), 0) as receivedAmount
                                        from customer_payments crp
                                        where crp.status = 'a'
                                        and crp.type = 'CR'
                                        and extract(year_month from crp.date) = '$yearMonth'
                                        UNION
                                        select
                                        ct.date,
                                        ifnull(sum(ct.in_amount), 0) as receivedAmount
                                        from cash_transactions ct
                                        where ct.status = 'a'
                                        and ct.type = 'In Cash'
                                        and extract(year_month from ct.date) = '$yearMonth') as tbl
                                        where date is not null
                                        group by extract(year_month from date)");

                $amount = 0.00;
                $monthName = date("M", mktime(0, 0, 0, $i, 10));

                if (count($query) == 0) {
                    $amount = 0.00;
                } else {
                    $amount = $query[0]->totalReceived;
                }
                $collection = [$monthName, floatval(number_format($amount, 2, '.', ''))];
                array_push($yearlyRecord, $collection);
            }

            $responseData = [
                'monthly_record'    => $monthlyRecord,
                'yearly_record'     => $yearlyRecord
            ];
            return response()->json($responseData, 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }
    public function topData(Request $request)
    {
        try {
            $dateY = explode("-", $request->dateFrom)[0];
            $fmonthOfYear = $dateY . "-01-01";
            $lmonthOfYear = $dateY . "-12-01";
            $dateFrom = !empty($request->fromSubmit) ? $request->dateFrom : $fmonthOfYear;
            $dateTo = !empty($request->fromSubmit) ? $request->dateTo : $lmonthOfYear;

            $customerClauses = "and bkm.date between '$dateFrom' and '$dateTo'";
            $productClauses = "and bkm.date between '$dateFrom' and '$dateTo'";
            // Top Customers
            $topCustomers = DB::select("
                    select 
                    ifnull(c.name, 'Cash Customer') as customer_name,
                    ifnull(sum(bkm.total), 0) as amount
                    from orders bkm 
                    left join customers c on c.id = bkm.customer_id
                    where bkm.status = 'a'
                    $customerClauses
                    group by bkm.customer_id
                    order by amount desc 
                    limit 10
                ");

            // Top Products
            $topMenus = DB::select("
                select 
                    m.name as menu_name,
                    ifnull(count(bkd.id), 0) as totaltable
                from order_details bkd
                left join orders bkm on bkm.id = bkd.order_id
                join menus m on m.id = bkd.menu_id
                where bkd.status = 'a'
                $productClauses
                group by bkd.menu_id
                order by totaltable desc
                limit 5
            ");

            $responseData = [
                'top_customers' => $topCustomers,
                'top_menus'  => $topMenus
            ];
            return response()->json($responseData, 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }
}
