<?php

namespace App\Http\Controllers\Administration;

use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RoomTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $roomTypes = RoomType::where('status', 'a')->latest()->get();
        return response()->json($roomTypes, 200);
    }

    public function create()
    {
        if (!checkAccess('roomType')) {
            return view('error.unauthorize');
        }

        return view('administration.room.roomtype');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);
        if ($validator->fails()) return send_error("Validation Error", $validator->errors(), 422);
        $roomtypename = RoomType::where('name', $request->name)->first();
        if (!empty($roomtypename)) return send_error("This name have been already exists", null, 422);
        try {
            $check = DB::table('room_types')->where('deleted_at', '!=', NULL)->where('name', $request->name)->first();;
            if (!empty($check)) {
                DB::select("UPDATE room_types SET deleted_by = NULL, deleted_at = NULL , status = 'a' WHERE id = ?", [$check->id]);
            } else {
                $data = new RoomType();
                $data->name = $request->name;
                $data->slug = make_slug($request->name);
                $data->status = 'a';
                $data->added_by = Auth::user()->id;
                $data->last_update_ip = request()->ip();
                $data->save();
            }

            return response()->json(['status' => true, 'message' => 'Room Type insert successfully'], 200);
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
        $roomtypename = RoomType::where('id', '!=', $request->id)->where('name', $request->name)->first();
        if (!empty($roomtypename)) return send_error("This name have been already exists", null, 422);
        try {
            $data = RoomType::find($request->id);
            $data->name = $request->name;
            $data->slug = make_slug($request->name);
            $data->updated_by = Auth::user()->id;
            $data->updated_at = Carbon::now();
            $data->last_update_ip = request()->ip();
            $data->update();
            
            return response()->json(['status' => true, 'message' => 'Room Type update successfully'], 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $data = RoomType::find($request->id);
            $data->status = 'd';
            $data->last_update_ip = request()->ip();
            $data->deleted_by = Auth::user()->id;
            $data->update();

            $data->delete();
            return response()->json(['status' => true, 'message' => 'Room Type delete successfully'], 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }
}
