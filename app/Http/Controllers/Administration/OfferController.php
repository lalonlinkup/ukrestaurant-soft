<?php

namespace App\Http\Controllers\Administration;

use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class OfferController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $offers = Offer::where('status', '!=', 'd')->latest()->get();
        return response()->json($offers, 200);
    }

    public function create()
    {
        if (!checkAccess('offer')) {
            return view('error.unauthorize');
        }

        return view('administration.website.offer');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'nullable'
        ]);
        if ($validator->fails()) return send_error("Validation Error", $validator->errors(), 422);
        try {
            $data         = new Offer();
            $offerKeys = $request->except('image', 'id');
            foreach (array_keys($offerKeys) as $key) {
                $data->$key = $request->$key;
            }
            if ($request->hasFile('image')) {
                $data->image = imageUpload($request, 'image', 'uploads/offer', uniqid().'_'.time());
            }
            $data->added_by = Auth::user()->id;
            $data->last_update_ip = request()->ip();
            $data->save();
            return response()->json("Offer insert successfully");
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'nullable'
        ]);
        if ($validator->fails()) return send_error("Validation Error", $validator->errors(), 422);
        try {
            $data         = Offer::find($request->id);
            $offerKeys = $request->except('image', 'id');
            foreach (array_keys($offerKeys) as $key) {
                $data->$key = $request->$key;
            }
            if ($request->hasFile('image')) {
                if (File::exists($data->image)) {
                    File::delete($data->image);
                }
                $data->image = imageUpload($request, 'image', 'uploads/offer', uniqid().'_'.time());
            }
            $data->updated_by = Auth::user()->id;
            $data->updated_at = Carbon::now();
            $data->last_update_ip = request()->ip();
            $data->update();

            return response()->json("Offer update successfully");
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $data = Offer::find($request->id);
            if (File::exists($data->image)) {
                File::delete($data->image);
                $data->image = null;
            }
            $data->status = 'd';
            $data->last_update_ip = request()->ip();
            $data->deleted_by = Auth::user()->id;
            $data->update();

            $data->delete();
            return response()->json("Offer delete successfully");
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }
}
