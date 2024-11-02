<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Specialtie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class SpecialtiesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $specialtie = Specialtie::where('status', 'a')->latest()->get();
        return response()->json($specialtie);
    }

    public function create()
    {
        // if (!checkAccess('specialtie')) {
        //     return view('error.unauthorize');
        // }

        return view('administration.website.specialtie');
    }

    public function store(Request $request)
    {
        
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        try {
            $data         = new Specialtie();
            $specialtieKeys = $request->except('image', 'id');
            foreach (array_keys($specialtieKeys) as $key) {
                $data->$key = $request->$key;
            }
            if ($request->hasFile('image')) {
                $data->image = imageUpload($request, 'image', 'uploads/specialtie', trim($data->title));
            }
            $data->added_by = Auth::user()->id;
            $data->last_update_ip = request()->ip();
            $data->save();
            return response()->json("Specialtie insert successfully");
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }
    public function update(Request $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        try {
            $data         = Specialtie::find($request->id);
            $specialtieKeys = $request->except('image', 'id');
            foreach (array_keys($specialtieKeys) as $key) {
                $data->$key = $request->$key;
            }
            if ($request->hasFile('image')) {
                if (File::exists($data->image)) {
                    File::delete($data->image);
                }
                $data->image = imageUpload($request, 'image', 'uploads/specialtie', trim($data->title));
            }
            $data->updated_by = Auth::user()->id;
            $data->updated_at = Carbon::now();
            $data->last_update_ip = request()->ip();
            $data->update();

            return response()->json("Specialtie update successfully");
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $data = Specialtie::find($request->id);
            if (File::exists($data->image)) {
                File::delete($data->image);
                $data->image = null;
            }
            $data->status = 'd';
            $data->last_update_ip = request()->ip();
            $data->deleted_by = Auth::user()->id;
            $data->update();

            $data->delete();
            return response()->json("Specialtie delete successfully");
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }
}
