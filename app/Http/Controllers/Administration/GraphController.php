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

            // total room
            $totalRoom = DB::select("
                    select count(*) as total_room
                    from rooms rm
                    where rm.status = 'a'
                ")[0]->total_room;

            // checkin list
            $checkin_date = date('Y-m-d') . ' 12:00:00';
            $rooms = DB::select("select r.*,
                                rt.name as roomtype_name
                                from rooms r
                                left join room_types rt on rt.id = r.room_type_id
                                where r.status != 'd' and r.deleted_at is null
                                ");

            foreach ($rooms as $key => $item) {
                $roomavailable = DB::select("select * from rooms rm where rm.id not in (select bkd.room_id from booking_details bkd where bkd.status = 'a' and '$checkin_date' between bkd.checkin_date and bkd.checkout_date) and rm.id = ?", [$item->id]);
                $item->available = count($roomavailable) > 0 ? 'true' : 'false';
                $roombooked = DB::select("select * from rooms rm where rm.id in (select bkd.room_id from booking_details bkd where bkd.status = 'a' and bkd.booking_status = 'booked' and '$checkin_date' between bkd.checkin_date and bkd.checkout_date) and rm.id = ?", [$item->id]);
                $item->booked = count($roombooked) > 0 ? 'true' : 'false';
                $roomcheckin = DB::select("select * from rooms rm where rm.id in (select bkd.room_id from booking_details bkd where bkd.status = 'a' and bkd.booking_status = 'checkin' and '$checkin_date' between bkd.checkin_date and bkd.checkout_date) and rm.id = ?", [$item->id]);
                $item->checkin = count($roomcheckin) > 0 ? 'true' : 'false';

                if ($item->available == 'true') {
                    $item->color = "#aee2ff";
                } else if ($item->booked == 'true') {
                    $item->color = '#fffcb2';
                } else if ($item->checkin == 'true') {
                    $item->color = '#ff0000ab';
                }
            }

            $checkIn = count(array_values(array_filter($rooms, function ($item) {
                return $item->checkin == 'true';
            })));

            $vacant = count(array_values(array_filter($rooms, function ($item) {
                return $item->available == 'true';
            })));

            $checkout = DB::select("select count(*) as checkout from booking_details bkd where bkd.status = 'a' and DATE_FORMAT(bkd.checkout_date, '%Y-%m-%d') = ?", [$today])[0]->checkout;
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
            $expense = DB::select("select ifnull(sum(ct.out_amount), 0) as expense
                        from cash_transactions ct
                        where ct.status = 'a'")[0]->expense;

            // Today's Cash Collection
            $todaysCollection = DB::select("
                    select
                    ifnull((
                        select sum(ifnull(bkm.advance, 0)) 
                        from booking_masters bkm
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
                        select sum(ifnull(bkm.advance, 0)) 
                        from booking_masters bkm
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
                'total_room'         => $totalRoom,
                'checkIn'            => $checkIn,
                'vacant'             => $vacant,
                'checkout'           => $checkout,
                'invest_balance'     => $investBalance,
                'loan_balance'       => $loanBalance,
                'today_collection'   => $todaysCollection,
                'monthly_collection' => $monthlyCollection,
                'cash_balance'      => $cashBalance,
                'bank_balance'   => $bankBalance,
                'due_amount'     => $customerDue,
                'total_employee' => $totalEmployee,
                'expense'        => $expense,
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
                                        ifnull(sum(bkm.advance), 0) as receivedAmount
                                        from booking_masters bkm 
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
                                        ifnull(sum(bkm.advance), 0) as receivedAmount
                                        from booking_masters bkm 
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
                // $query = DB::select("select
                //             (select ifnull(sum(crp.amount), 0) from customer_payments crp 
                //             where crp.booking_id = bkm.id and crp.status = 'a') as cusPayment,
                //             (select ifnull(sum(bkm.advance), 0) + cusPayment) as receivedAmount
                //             from booking_masters bkm
                //             where bkm.status = 'a'
                //             and extract(year_month from bkm.date) = ?
                //             group by extract(year_month from bkm.date)", [$yearMonth]);

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
                    from booking_masters bkm 
                    left join customers c on c.id = bkm.customer_id
                    where bkm.status = 'a'
                    $customerClauses
                    group by bkm.customer_id
                    order by amount desc 
                    limit 10
                ");

            // Top Products
            $topProducts = DB::select("
                        select 
                            r.name as room_name,
                            ifnull(count(bkd.id), 0) as totalroom
                        from booking_details bkd
                        left join booking_masters bkm on bkm.id = bkd.booking_id
                        join rooms r on r.id = bkd.room_id
                        where bkd.status = 'a'
                        $productClauses
                        group by bkd.room_id
                        order by totalroom desc
                        limit 5
                    ");


            $responseData = [
                'top_customers'     => $topCustomers,
                'top_products'      => $topProducts
            ];
            return response()->json($responseData, 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }
}
