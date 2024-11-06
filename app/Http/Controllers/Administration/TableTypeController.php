<?php

namespace App\Http\Controllers\Administration;

use App\Models\TableType;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TableTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $tableTypes = TableType::where('status', 'a')->latest()->get();
        return response()->json($tableTypes, 200);
    }

    public function create()
    {
        if (!checkAccess('tableType')) {
            return view('error.unauthorize');
        }

        return view('administration.table.tabletype');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);
        if ($validator->fails()) return send_error("Validation Error", $validator->errors(), 422);
        $tabletypename = TableType::where('name', $request->name)->first();
        if (!empty($tabletypename)) return send_error("This name have been already exists", null, 422);
        try {
            $check = DB::table('table_types')->where('deleted_at', '!=', NULL)->where('name', $request->name)->first();;
            if (!empty($check)) {
                DB::select("UPDATE table_types SET deleted_by = NULL, deleted_at = NULL , status = 'a' WHERE id = ?", [$check->id]);
            } else {
                $data = new TableType();
                $data->name = $request->name;
                $data->slug = make_slug($request->name);
                $data->status = 'a';
                $data->added_by = Auth::user()->id;
                $data->last_update_ip = request()->ip();
                $data->save();
            }

            return response()->json(['status' => true, 'message' => 'Table Type insert successfully'], 200);
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
        $tabletypename = TableType::where('id', '!=', $request->id)->where('name', $request->name)->first();
        if (!empty($tabletypename)) return send_error("This name have been already exists", null, 422);
        try {
            $data = TableType::find($request->id);
            $data->name = $request->name;
            $data->slug = make_slug($request->name);
            $data->updated_by = Auth::user()->id;
            $data->updated_at = Carbon::now();
            $data->last_update_ip = request()->ip();
            $data->update();
            
            return response()->json(['status' => true, 'message' => 'Table Type update successfully'], 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $data = TableType::find($request->id);
            $data->status = 'd';
            $data->last_update_ip = request()->ip();
            $data->deleted_by = Auth::user()->id;
            $data->update();

            $data->delete();
            return response()->json(['status' => true, 'message' => 'Table Type delete successfully'], 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }
}
