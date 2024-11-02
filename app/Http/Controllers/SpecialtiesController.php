<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Specialtie;
use App\Models\SpecialtieBanner;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class SpecialtiesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $specialtie = Specialtie::where('status', 'a')->latest()->get();
        $banner = SpecialtieBanner::first();
        return response()->json([
            'specialtie' => $specialtie,
            'banner' => $banner,
        ]);

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
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
            'image' => 'required|image',
            
        ], [
            'title.required' => 'The title is required.',
            'price.required' => 'The price is required.',
            'price.numeric' => 'The price must be number.',
            'description.required' => 'The description is required.',
            'image.required' => 'The image is required.',
            
        ]);        

        if ($validator->fails()) {
            return send_error($validator->errors()->first());
        }
        $data = $request->except('image', 'id');

        try {
            if ($request->hasFile('image')) {
                $data['image'] = imageUpload($request, 'image', 'uploads/specialtie', trim($data['title']));
            }
            $data['added_by'] = Auth::user()->id;
            $data['last_update_ip'] = request()->ip();
            Specialtie::create($data);
            return response()->json("Specialtie insert successfully");
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
            
        ], [
            'title.required' => 'The title is required.',
            'price.required' => 'The price is required.',
            'price.numeric' => 'The price must be number.',
            'description.required' => 'The description is required.',
        ]);        

        if ($validator->fails()) {
            return send_error($validator->errors()->first());
        }
        $oldData = Specialtie::find($request->id);
        $data = $request->except('image', 'id');
        try {
            $data['image'] = $oldData->image;
            if ($request->hasFile('image')) {
                if (File::exists($oldData->image)) {
                    File::delete($oldData->image);
                }
                $data['image'] = imageUpload($request, 'image', 'uploads/specialtie', trim($data['title']));
            }
            $data['updated_by'] = Auth::user()->id;
            $data['updated_at'] = Carbon::now();
            $data['last_update_ip'] = request()->ip();
            $oldData->update($data);

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

    public function updateBanner(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image',
            
        ], [
            'image.required' => 'The image is required.',
            'image.image' => 'The image must be a image.',
        ]);        

        if ($validator->fails()) {
            return send_error($validator->errors()->first());
        }


        $oldData = SpecialtieBanner::first();
        $data = $request->except('image', 'id');
        try {
            $data['image'] = $oldData->image;
            if ($request->hasFile('image')) {
                if (File::exists($oldData->image)) {
                    File::delete($oldData->image);
                }
                $data['image'] = imageUpload($request, 'image', 'uploads/specialtie', 'banner');
            }
            $data['updated_by'] = Auth::user()->id;
            $data['updated_at'] = Carbon::now();
            $data['last_update_ip'] = request()->ip();
            $oldData->update($data);

            return response()->json("Specialtie Banner update successfully");
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }
}
