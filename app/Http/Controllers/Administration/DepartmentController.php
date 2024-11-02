<?php

namespace App\Http\Controllers\Administration;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $departments = Department::latest()->get();
        return response()->json($departments);
    }

    public function create()
    {
        if (!checkAccess('department')) {
            return view('error.unauthorize');
        }

        return view('administration.hrpayroll.department');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:departments'
        ]);
        if ($validator->fails()) return send_error("Validation Error", $validator->errors(), 422);
        $departmentunique = Department::where('name', $request->name)->first();
        if (!empty($departmentunique)) return send_error("This name have been already exists", null, 422);

        try {
            $check = DB::table('departments')->where('deleted_at', '!=', NULL)->where('name', $request->name)->first();;
            if (!empty($check)) {
                DB::select("UPDATE departments SET deleted_by = NULL, deleted_at = NULL , status = 'a' WHERE id = ?", [$check->id]);
            } else {
                $data = new Department();
                $data->name = $request->name;
                $data->added_by = Auth::user()->id;
                $data->last_update_ip = request()->ip();
                $data->save();
            }

            return response()->json("Department insert successfully");
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:departments,name,' . $request->id
        ]);
        if ($validator->fails()) return send_error("Validation Error", $validator->errors(), 422);
        $departmentunique = Department::where('id', '!=', $request->id)->where('name', $request->name)->first();
        if (!empty($departmentunique)) return send_error("This name have been already exists", null, 422);
        try {
            $data = Department::find($request->id);
            $data->name = $request->name;
            $data->updated_by = Auth::user()->id;
            $data->updated_at = Carbon::now();
            $data->last_update_ip = request()->ip();
            $data->update();

            return response()->json("Department update successfully");
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $data = Department::find($request->id);
            $data->status = 'd';
            $data->last_update_ip = request()->ip();
            $data->deleted_by = Auth::user()->id;
            $data->update();

            $data->delete();
            return response()->json("Department delete successfully");
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }
}
