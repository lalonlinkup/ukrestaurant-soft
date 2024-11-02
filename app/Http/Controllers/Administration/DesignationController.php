<?php

namespace App\Http\Controllers\Administration;

use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DesignationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $designations = Designation::latest()->get();
        return response()->json($designations);
    }

    public function create()
    {
        if (!checkAccess('designation')) {
            return view('error.unauthorize');
        }

        return view('administration.hrpayroll.designation');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:designations'
        ]);
        if ($validator->fails()) return send_error("Validation Error", $validator->errors(), 422);

        $designationunique = Designation::where('name', $request->name)->first();
        if (!empty($designationunique)) return send_error("This name have been already taken", null, 422);
        try {
            $check = DB::table('designations')->where('deleted_at', '!=', NULL)->where('name', $request->name)->first();;
            if (!empty($check)) {
                DB::select("UPDATE designations SET deleted_by = NULL, deleted_at = NULL , status = 'a' WHERE id = ?", [$check->id]);
            } else {
                $data = new Designation();
                $data->name = $request->name;
                $data->added_by = Auth::user()->id;
                $data->last_update_ip = request()->ip();
                $data->save();
            }

            return response()->json("Designation insert successfully");
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:designations,name,' . $request->id
        ]);
        if ($validator->fails()) return send_error("Validation Error", $validator->errors(), 422);

        $designationunique = Designation::where('id', '!=', $request->id)->where('name', $request->name)->first();
        if (!empty($designationunique)) return send_error("This name have been already taken", null, 422);
        try {
            $data = Designation::find($request->id);
            $data->name = $request->name;
            $data->updated_by = Auth::user()->id;
            $data->updated_at = Carbon::now();
            $data->last_update_ip = request()->ip();
            $data->update();

            return response()->json("Designation update successfully");
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $data = Designation::find($request->id);
            $data->status = 'd';
            $data->last_update_ip = request()->ip();
            $data->deleted_by = Auth::user()->id;
            $data->update();

            $data->delete();
            return response()->json("Designation delete successfully");
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }
}
