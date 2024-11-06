<?php

namespace App\Http\Controllers\Administration;

use Carbon\Carbon;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ServiceRequest;
use App\Models\BookingDetail;
use App\Models\BookingMaster;
use App\Models\Customer;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $clauses = "";
        if (!empty($request->bookingId)) {
            $clauses .= " AND s.booking_id = '$request->bookingId'";
        }
        if (!empty($request->tableId)) {
            $clauses .= " AND s.table_id = '$request->tableId'";
        }
        if (!empty($request->customerId)) {
            $clauses .= " AND s.customer_id = '$request->customerId'";
        }
        if (!empty($request->headId)) {
            $clauses .= " AND s.service_head_id = '$request->headId'";
        }
        if (!empty($request->dateFrom) && !empty($request->dateTo)) {
            $clauses .= " AND s.date BETWEEN '$request->dateFrom' AND '$request->dateTo'";
        }

        $services = DB::select("SELECT s.*,
                            r.name AS table_name,
                            c.code AS customer_code,
                            c.name AS customer_name,
                            c.phone AS customer_phone,
                            c.address AS customer_address,
                            sh.code AS head_code,
                            sh.name AS head_name
                            FROM services s
                            LEFT JOIN tables r ON r.id = s.table_id
                            LEFT JOIN customers c ON c.id = s.customer_id
                            LEFT JOIN service_heads sh ON sh.id = s.service_head_id
                            WHERE s.status != 'd' AND s.deleted_at IS NULL 
                            $clauses
                            ORDER BY s.id DESC
                            ");
        return response()->json($services, 200);
    }

    public function create()
    {
        if (!checkAccess('service')) {
            return view('error.unauthorize');
        }

        return view('administration.service.create');
    }

    public function store(ServiceRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);

        try {
            $data     = new Service();
            $serviceKeys = $request->except('id');
            foreach (array_keys($serviceKeys) as $key) {
                $data->$key = $request->$key;
            }

            $data->added_by       = Auth::user()->id;
            $data->last_update_ip = request()->ip();
            $data->save();

            return response()->json(['status' => true, 'message' => 'Service insert successfully'], 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }
    public function update(ServiceRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);

        try {
            $data = Service::find($request->id);
            $serviceKeys = $request->except('id');
            foreach (array_keys($serviceKeys) as $key) {
                $data->$key = $request->$key;
            }

            $data->updated_by     = Auth::user()->id;
            $data->updated_at     = Carbon::now();
            $data->last_update_ip = request()->ip();
            $data->update();

            return response()->json(['status' => true, 'message' => 'Service update successfully'], 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $data                 = Service::find($request->id);
            $data->status         = 'd';
            $data->last_update_ip = request()->ip();
            $data->deleted_by     = Auth::user()->id;
            $data->update();

            $data->delete();
            return response()->json("Service delete successfully", 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function list()
    {
        if (!checkAccess('serviceList')) {
            return view('error.unauthorize');
        }

        return view('administration.service.list');
    }

    public function getCheckinCustomer(Request $request)
    {
        $detail = BookingDetail::where('table_id', $request->tableId)->where('checkin_date', '<=', $request->date . ' 12:00:00')->where('checkout_date', '>=', $request->date . ' 11:59:00')->where('booking_status', 'checkin')->orderBy('id', 'DESC')->first();
        if ($detail) {
            $booking = BookingMaster::where('id', $detail->booking_id)->first();
            $customer = Customer::where('id', $booking->customer_id)->select('id', 'code', 'name', 'phone', 'address')->first();
            $customer->booking_id = $booking->id;
        } else {
            $customer = null;
        }

        return response()->json($customer);
    }
}
