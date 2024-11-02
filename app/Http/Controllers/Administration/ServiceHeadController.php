<?php

namespace App\Http\Controllers\Administration;

use Carbon\Carbon;
use App\Models\ServiceHead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ServiceHeadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $clauses = "";
        if (!empty($request->headId)) {
            $clauses .= " and sh.id = '$request->headId'";
        }

        $heads = DB::select("select sh.*
                            from service_heads sh
                            where sh.status != 'd' and sh.deleted_at is null 
                            $clauses
                            order by sh.id desc
                            ");
        return response()->json($heads, 200);
    }

    public function create()
    {
        if (!checkAccess('serviceHead')) {
            return view('error.unauthorize');
        }

        return view('administration.service.head');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string',
            'name' => 'required|string',
        ]);
        
        if ($validator->fails()) return send_error("Validation Error", $validator->errors(), 422);
        
        $exists = ServiceHead::where('name', $request->name)->exists();
        if ($exists) {
            return response()->json(['status' => true, 'message' => "The service head name already exits!"], 422);
        }
        try {
            $check = DB::table('service_heads')->where('deleted_at', '!=', NULL)->where('name', $request->name)->first();
            if (!empty($check)) {
                DB::select("UPDATE service_heads SET deleted_by = NULL, deleted_at = NULL , status = 'a' WHERE id = ?", [$check->id]);
            } else {
                $data     = new ServiceHead();
                $headKeys = $request->except('id');
                foreach (array_keys($headKeys) as $key) {
                    $data->$key = $request->$key;
                }
                
                $data->added_by       = Auth::user()->id;
                $data->last_update_ip = request()->ip();
                $data->save();
            }

            return response()->json(['status' => true, 'message' => 'Service Head insert successfully', 'code' => generateCode('ServiceHead', 'SH')], 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string',
            'name' => 'required|string',
        ]);
        
        if ($validator->fails()) return send_error("Validation Error", $validator->errors(), 422);

        $exists = ServiceHead::where('name', $request->name)
            ->where('id', '!=', $request->id)
            ->exists();
        if ($exists) {
            return response()->json(['status' => true, 'message' => "The service head name already exits!"], 422);
        }
        try {
            $data = ServiceHead::find($request->id);
            $headKeys = $request->except('id');
            foreach (array_keys($headKeys) as $key) {
                $data->$key = $request->$key;
            }
            
            $data->updated_by     = Auth::user()->id;
            $data->updated_at     = Carbon::now();
            $data->last_update_ip = request()->ip();
            $data->update();

            return response()->json(['status' => true, 'message' => 'Service head update successfully', 'code' => generateCode('ServiceHead', 'SH')], 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $data                 = ServiceHead::find($request->id);
            $data->status         = 'd';
            $data->last_update_ip = request()->ip();
            $data->deleted_by     = Auth::user()->id;
            $data->update();

            $data->delete();
            return response()->json("Service Head delete successfully", 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function list()
    {
        if (!checkAccess('serviceHeadList')) {
            return view('error.unauthorize');
        }

        return view('administration.inventory.headList');
    }
}

