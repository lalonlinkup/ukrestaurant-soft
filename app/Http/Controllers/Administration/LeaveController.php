<?php

namespace App\Http\Controllers\Administration;

use Carbon\Carbon;
use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LeaveController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $whereCluase = [];
        if (!empty($request->employeeId)) {
            array_push($whereCluase, ['employee_id', '=', $request->employeeId]);
        }
        if (!empty($request->typeId)) {
            array_push($whereCluase, ['leave_type_id', '=', $request->typeId]);
        }
        if (!empty($request->dateFrom) && !empty($request->dateTo)) {
            array_push($whereCluase, ['date', '>=', $request->dateFrom]);
            array_push($whereCluase, ['date', '<=', $request->dateTo]);
        }
        $leaves = Leave::with('employee', 'leaveType')->where($whereCluase)->latest()->get();
        return response()->json($leaves);
    }

    public function create()
    {
        if (!checkAccess('leaveEntry')) {
            return view('error.unauthorize');
        }

        return view('administration.hrpayroll.leave');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required',
            'leave_type_id' => 'required',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'days' => 'required|numeric'
        ]);
        
        if ($validator->fails()) return send_error("Validation Error", $validator->errors(), 422);
        
        try {
            $check = DB::table('leaves')->where('deleted_at', '!=', NULL)->where(['employee_id' => $request->employee_id, 'leave_type_id' => $request->leave_type_id, 'from_date' => $request->from_date, 'to_date' => $request->to_date])->first();
            if (!empty($check)) {
                DB::select("UPDATE leaves SET deleted_by = NULL, deleted_at = NULL , status = 'a' WHERE id = ?", [$check->id]);
            } else {
                $data = new Leave();
                $leaveKeys = $request->except('id');
                foreach (array_keys($leaveKeys) as $key) {
                    $data->$key = $request->$key;
                }
                $data->added_by = Auth::user()->id;
                $data->last_update_ip = request()->ip();
                $data->save();
            }
            return response()->json(['status' => true, 'message' => 'Leave insert successfully.!'], 200);
        } catch (\Exception $ex) {
            return send_error("Something went wrong", $ex->getMessage());
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required',
            'leave_type_id' => 'required',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'days' => 'required|numeric'
        ]);
        
        if ($validator->fails()) return send_error("Validation Error", $validator->errors(), 422);
        
        try {
            $check = DB::table('leaves')->where('deleted_at', '!=', NULL)->where(['employee_id' => $request->employee_id, 'leave_type_id' => $request->leave_type_id, 'from_date' => $request->from_date, 'to_date' => $request->to_date])->first();
            if (!empty($check)) {
                DB::select("UPDATE leaves SET deleted_by = NULL, deleted_at = NULL , status = 'a' WHERE id = ?", [$check->id]);
            } else {
                $data = Leave::find($request->id);
                $leaveKeys = $request->except('id');
                foreach (array_keys($leaveKeys) as $key) {
                    $data->$key = $request->$key;
                }
                $data->updated_by     = Auth::user()->id;
                $data->updated_at     = Carbon::now();
                $data->last_update_ip = request()->ip();
                $data->update();
            }
            return response()->json(['status' => true, 'message' => 'Leave Update successfully.!'], 200);
        } catch (\Exception $ex) {
            return send_error("Something went wrong", $ex->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $data                 = Leave::find($request->id);
            $data->status         = 'd';
            $data->last_update_ip = request()->ip();
            $data->deleted_by     = Auth::user()->id;
            $data->update();

            $data->delete();
            return response()->json("Leave delete successfully", 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function record()
    {
        if (!checkAccess('leaveEntry')) {
            return view('error.unauthorize');
        }

        return view('administration.hrpayroll.leaveRecord');
    }
}
