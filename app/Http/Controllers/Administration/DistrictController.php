<?php

namespace App\Http\Controllers\Administration;

use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DistrictController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $districts = District::latest()->get();
        return response()->json($districts);
    }

    public function create()
    {
        if (!checkAccess('district')) {
            return view('error.unauthorize');
        }

        return view('administration.settings.district');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:districts'
        ]);
        if ($validator->fails()) return send_error("Validation Error", $validator->errors(), 422);
        $districtunique = District::where('name', $request->name)->first();
        if (!empty($districtunique)) return send_error("This name have been already taken", null, 422);

        try {
            $check = DB::table('districts')->where('deleted_at', '!=', NULL)->where('name', $request->name)->first();;
            if (!empty($check)) {
                DB::select("UPDATE districts SET deleted_by = NULL, deleted_at = NULL , status = 'a' WHERE id = ?", [$check->id]);
            } else {
                $data = new District();
                $data->name = $request->name;
                $data->added_by = Auth::user()->id;
                $data->last_update_ip = request()->ip();
                $data->save();
            }

            return response()->json("Area insert successfully");
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:districts,name,'. $request->id
        ]);
        if ($validator->fails()) return send_error("Validation Error", $validator->errors(), 422);
        $districtunique = District::where('id', '!=', $request->id)->where('name', $request->name)->first();
        if (!empty($districtunique)) return send_error("This name have been already taken", null, 422);
        try {
            $data = District::find($request->id);
            $data->name = $request->name;
            $data->updated_by = Auth::user()->id;
            $data->updated_at = Carbon::now();
            $data->last_update_ip = request()->ip();
            $data->update();

            return response()->json("Area update successfully");
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $data = District::find($request->id);
            $data->status = 'd';
            $data->last_update_ip = request()->ip();
            $data->deleted_by = Auth::user()->id;
            $data->update();

            $data->delete();
            return response()->json("Area delete successfully");
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }
}
