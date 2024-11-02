<?php

namespace App\Http\Controllers\Administration;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Requests\RoomRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class RoomController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $clauses = "";
        if (!empty($request->floorId)) {
            $clauses .= " and r.floor_id = '$request->floorId'";
        }
        if (!empty($request->categoryId)) {
            $clauses .= " and r.category_id = '$request->categoryId'";
        }
        if (!empty($request->roomtypeId)) {
            $clauses .= " and r.room_type_id = '$request->roomtypeId'";
        }
        if (!empty($request->roomId)) {
            $clauses .= " and r.id = '$request->roomId'";
        }

        $rooms = DB::select("select r.*,
                            f.name as floor_name,
                            c.name as category_name,
                            rt.name as roomtype_name
                            from rooms r
                            left join floors f on f.id = r.floor_id
                            left join categories c on c.id = r.category_id
                            left join room_types rt on rt.id = r.room_type_id
                            where r.status != 'd' and r.deleted_at is null 
                            $clauses");
        return response()->json($rooms, 200);
    }

    public function create()
    {
        if (!checkAccess('room')) {
            return view('error.unauthorize');
        }

        return view('administration.room.create');
    }

    public function store(RoomRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        $exists = Room::where('name', $request->name)
            ->where('category_id', $request->category_id)
            ->exists();
        if ($exists) {
            return response()->json(['status' => true, 'message' => "The room name must be unique for the given category!"], 422);
        }
        try {
            $check = DB::table('rooms')->where('deleted_at', '!=', NULL)->where('name', $request->name)->first();
            if (!empty($check)) {
                DB::select("UPDATE rooms SET deleted_by = NULL, deleted_at = NULL , status = 'a' WHERE id = ?", [$check->id]);
            } else {
                $data     = new Room();
                $roomKeys = $request->except('id', 'image');
                foreach (array_keys($roomKeys) as $key) {
                    $data->$key = $request->$key;
                }

                if ($request->hasFile('image')) {
                    $data->image = imageUpload($request, 'image', 'uploads/room', trim($data->code));
                }
                $data->added_by       = Auth::user()->id;
                $data->last_update_ip = request()->ip();
                $data->save();
            }

            return response()->json(['status' => true, 'message' => 'Room insert successfully', 'code' => generateCode('Room', 'R')], 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }
    public function update(RoomRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        $exists = Room::where('name', $request->name)
            ->where('category_id', $request->category_id)
            ->where('id', '!=', $request->id)
            ->exists();
        if ($exists) {
            return response()->json(['status' => true, 'message' => "The room name must be unique for the given category!"], 422);
        }
        try {
            $data = Room::find($request->id);
            $data->code = generateCode("Room", 'R');
            $roomKeys = $request->except('id', 'image');
            foreach (array_keys($roomKeys) as $key) {
                $data->$key = $request->$key;
            }
            if ($request->hasFile('image')) {
                if (File::exists($data->image)) {
                    File::delete($data->image);
                }
                $data->image = imageUpload($request, 'image', 'uploads/room', trim($data->code));
            }
            $data->updated_by     = Auth::user()->id;
            $data->updated_at     = Carbon::now();
            $data->last_update_ip = request()->ip();
            $data->update();

            return response()->json(['status' => true, 'message' => 'Room update successfully', 'code' => generateCode('Room', 'R')], 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $data                 = Room::find($request->id);
            $data->status         = 'd';
            $data->last_update_ip = request()->ip();
            $data->deleted_by     = Auth::user()->id;
            $data->update();

            $data->delete();
            return response()->json("Room delete successfully", 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function roomList()
    {
        if (!checkAccess('roomList')) {
            return view('error.unauthorize');
        }

        return view('administration.room.roomlist');
    }
}
