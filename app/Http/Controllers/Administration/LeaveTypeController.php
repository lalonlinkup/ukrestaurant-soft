<?php

namespace App\Http\Controllers\Administration;

use Carbon\Carbon;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LeaveTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $types = LeaveType::where('status', 'a')->latest()->get();
        return response()->json($types, 200);
    }

    public function create()
    {
        if (!checkAccess('leaveType')) {
            return view('error.unauthorize');
        }

        return view('administration.hrpayroll.leaveType');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'days' => 'required|numeric',
        ]);
        if ($validator->fails()) return send_error("Validation Error", $validator->errors(), 422);
        $exits = LeaveType::where('name', $request->name)->first();
        if (!empty($exits)) return send_error("This name have been already exists", null, 422);
        try {
            $check = DB::table('leave_types')->where('deleted_at', '!=', NULL)->where('name', $request->name)->first();;
            if (!empty($check)) {
                DB::select("UPDATE leave_types SET deleted_by = NULL, deleted_at = NULL , status = 'a' WHERE id = ?", [$check->id]);
            } else {
                $data = new LeaveType();
                $data->name = $request->name;
                $data->days = $request->days;
                $data->status = 'a';
                $data->added_by = Auth::user()->id;
                $data->last_update_ip = request()->ip();
                $data->save();
            }

            return response()->json(['status' => true, 'message' => 'Leave Type insert successfully'], 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'days' => 'required|numeric'
        ]);
        if ($validator->fails()) return send_error("Validation Error", $validator->errors(), 422);
        $exits = LeaveType::where('id', '!=', $request->id)->where('name', $request->name)->first();
        if (!empty($exits)) return send_error("This name have been already exists", null, 422);
        try {
            $data = LeaveType::find($request->id);
            $data->name = $request->name;
            $data->days = $request->days;
            $data->updated_by = Auth::user()->id;
            $data->updated_at = Carbon::now();
            $data->last_update_ip = request()->ip();
            $data->update();
            
            return response()->json(['status' => true, 'message' => 'Leave Type update successfully'], 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $data = LeaveType::find($request->id);
            $data->status = 'd';
            $data->last_update_ip = request()->ip();
            $data->deleted_by = Auth::user()->id;
            $data->update();

            $data->delete();
            return response()->json(['status' => true, 'message' => 'Leave Type delete successfully'], 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }
}
