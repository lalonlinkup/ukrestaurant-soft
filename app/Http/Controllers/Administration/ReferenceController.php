<?php

namespace App\Http\Controllers\Administration;

use Carbon\Carbon;
use App\Models\Reference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ReferenceRequest;

class ReferenceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request) {
        $references = Reference::where('status', 'a')->get();
        return response()->json($references);
    }

    public function create()
    {
        if (!checkAccess('reference')) {
            return view('error.unauthorize');
        }

        $code = generateCode("Reference", 'R');
        return view('administration.settings.reference', compact('code'));
    }

    public function store(ReferenceRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        $phoneUique = Reference::where('phone', $request->phone)->first();
        if (!empty($phoneUique)) return send_error("This phone have been already used", null, 422);

        try {
            $check = DB::table('references')->where('deleted_at', '!=', NULL)->where('phone', $request->phone)->first();
            if (!empty($check)) {
                DB::select("UPDATE references SET deleted_by = NULL, deleted_at = NULL , status = 'a' WHERE id = ?", [$check->id]);
            } else {
                $data = new Reference();

                $refKeys = $request->except('id');
                foreach (array_keys($refKeys) as $key) {
                    $data->$key = $request->$key;
                }

                $data->added_by = Auth::user()->id;
                $data->last_update_ip = request()->ip();
                $data->save();
            }

            return response()->json(['message' => "Reference insert successfully", 'code' => generateCode("Reference", 'R')]);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function update(ReferenceRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        $phoneUique = Reference::where('phone', $request->phone)->where('id', '!=', $request->id)->first();
        if (!empty($phoneUique)) return send_error("This phone have been already used", null, 422);

        try {
            $data = Reference::find($request->id);

            $refKeys = $request->except('id');
            foreach (array_keys($refKeys) as $key) {
                $data->$key = $request->$key;
            }

            $data->updated_by = Auth::user()->id;
            $data->last_update_ip = request()->ip();
            $data->updated_at = Carbon::now();
            $data->update();

            return response()->json(['message' => "Reference update successfully", 'code' => generateCode("Reference", 'R')]);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $data = Reference::find($request->id);
            $data->status = 'd';
            $data->last_update_ip = request()->ip();
            $data->deleted_by = Auth::user()->id;
            $data->update();

            $data->delete();
            return response()->json("Reference delete successfully");
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }
}
