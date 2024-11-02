<?php

namespace App\Http\Controllers\Administration;

use Carbon\Carbon;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $brands = Brand::where('status', 'a')->latest()->get();
        return response()->json($brands, 200);
    }

    public function create()
    {
        if (!checkAccess('brand')) {
            return view('error.unauthorize');
        }

        return view('administration.inventory.brand');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);
        if ($validator->fails()) return send_error("Validation Error", $validator->errors(), 422);
        $exits = Brand::where('name', $request->name)->first();
        if (!empty($exits)) return send_error("This name have been already exists", null, 422);
        try {
            $check = DB::table('brands')->where('deleted_at', '!=', NULL)->where('name', $request->name)->first();;
            if (!empty($check)) {
                DB::select("UPDATE brands SET deleted_by = NULL, deleted_at = NULL , status = 'a' WHERE id = ?", [$check->id]);
            } else {
                $data = new Brand();
                $data->name = $request->name;
                $data->status = 'a';
                $data->added_by = Auth::user()->id;
                $data->last_update_ip = request()->ip();
                $data->save();
            }

            return response()->json(['status' => true, 'message' => 'Brand insert successfully'], 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);
        if ($validator->fails()) return send_error("Validation Error", $validator->errors(), 422);
        $exits = Brand::where('id', '!=', $request->id)->where('name', $request->name)->first();
        if (!empty($exits)) return send_error("This name have been already exists", null, 422);
        try {
            $data = Brand::find($request->id);
            $data->name = $request->name;
            $data->updated_by = Auth::user()->id;
            $data->updated_at = Carbon::now();
            $data->last_update_ip = request()->ip();
            $data->update();
            
            return response()->json(['status' => true, 'message' => 'Brand update successfully'], 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $data = Brand::find($request->id);
            $data->status = 'd';
            $data->last_update_ip = request()->ip();
            $data->deleted_by = Auth::user()->id;
            $data->update();

            $data->delete();
            return response()->json(['status' => true, 'message' => 'Brand delete successfully'], 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }
}
