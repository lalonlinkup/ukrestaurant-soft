<?php

namespace App\Http\Controllers\Administration;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\GalleryRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ManageRequest;
use App\Models\AboutPage;
use App\Models\Manage;
use Illuminate\Support\Facades\Validator;

class WebsiteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function manage()
    {
        if (!checkAccess('management')) {
            return view('error.unauthorize');
        }

        return view('administration.website.management');
    }

    public function getManage(Request $request)
    {
        $whereCluase = [
            ['status', '=', 'a']
        ];
        if (!empty($request->forSearch)) {
            $manages = Manage::with('designation')->where($whereCluase)->limit(20)->latest()->get();
        } elseif (!empty($request->name)) {
            $manages = Manage::with('designation')->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->name . '%')
                    ->orWhere('code', 'like', '%' . $request->name . '%');
            })->get();
        } else {
            $manages = Manage::with('designation')->where($whereCluase)->latest()->get();
        }

        return response()->json($manages);
    }

    public function manageStore(ManageRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        $supunique = Manage::where('phone', $request->phone)->first();
        if (!empty($supunique)) return send_error("This phone number have been already exist..!", null, 422);
        try {
            $check = DB::table('manages')->where('deleted_at', '!=', NULL)->where('phone', $request->phone)->first();;
            if (!empty($check)) {
                DB::select("UPDATE manage SET deleted_by = NULL, deleted_at = NULL , status = 'a' WHERE id = ?", [$check->id]);
            } else {
                $manage_code = DB::select("select code from manages where code = ?", [$request->code]);
                if (count($manage_code) > 0) {
                    $code = generateCode('manage', 'C');
                } else {
                    $code = $request->code;
                }
                $data         = new Manage();
                $data->code   = $code;
                $manageKeys = $request->except('image', 'id', 'code');
                foreach (array_keys($manageKeys) as $key) {
                    $data->$key = $request->$key;
                }
                if ($request->hasFile('image')) {
                    $data->image = imageUpload($request, 'image', 'uploads/manage', trim($data->code));
                }
                $data->added_by = Auth::user()->id;
                $data->last_update_ip = request()->ip();
                $data->save();
            }
            return response()->json("manage insert successfully");
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }
    public function manageUpdate(ManageRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        $supunique = manage::where('id', '!=', $request->id)->where('phone', $request->phone)->first();
        if (!empty($supunique)) return send_error("This phone number have been already exist..!", null, 422);
        try {
            $manage_code = DB::select("select code from manages where code = ? and id != ?", [$request->code, $request->id]);
            if (count($manage_code) > 0) return send_error("This supplier code already exists", null, 422);

            $data         = Manage::find($request->id);
            $manageKeys = $request->except('image', 'id');
            foreach (array_keys($manageKeys) as $key) {
                $data->$key = $request->$key;
            }
            if ($request->hasFile('image')) {
                if (File::exists($data->image)) {
                    File::delete($data->image);
                }
                $data->image = imageUpload($request, 'image', 'uploads/manage', trim($data->code));
            }
            $data->updated_by = Auth::user()->id;
            $data->updated_at = Carbon::now();
            $data->last_update_ip = request()->ip();
            $data->update();

            return response()->json("manage update successfully");
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function manageDestroy(Request $request)
    {
        try {
            $data = Manage::find($request->id);
            if (File::exists($data->image)) {
                File::delete($data->image);
                $data->image = null;
            }
            $data->status = 'd';
            $data->last_update_ip = request()->ip();
            $data->deleted_by = Auth::user()->id;
            $data->update();

            $data->delete();
            return response()->json("manage delete successfully");
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    //gallery
    public function gallery()
    {
        if (!checkAccess('gallery')) {
            return view('error.unauthorize');
        }

        return view('administration.website.gallery');
    }

    public function getGallery(Request $request)
    {

        $galleries = Gallery::latest()->get();

        return response()->json($galleries);
    }

    public function galleryStore(GalleryRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        try {
            $data         = new Gallery();
            $galleryKeys = $request->except('image', 'id');
            foreach (array_keys($galleryKeys) as $key) {
                $data->$key = $request->$key;
            }
            if ($request->hasFile('image')) {
                $data->image = imageUpload($request, 'image', 'uploads/gallery', trim($data->title));
            }
            $data->added_by = Auth::user()->id;
            $data->last_update_ip = request()->ip();
            $data->save();
            return response()->json("Gallery insert successfully");
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }
    public function galleryUpdate(GalleryRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        try {
            $data         = Gallery::find($request->id);
            $galleryKeys = $request->except('image', 'id');
            foreach (array_keys($galleryKeys) as $key) {
                $data->$key = $request->$key;
            }
            if ($request->hasFile('image')) {
                if (File::exists($data->image)) {
                    File::delete($data->image);
                }
                $data->image = imageUpload($request, 'image', 'uploads/gallery', trim($data->title));
            }
            $data->updated_by = Auth::user()->id;
            $data->updated_at = Carbon::now();
            $data->last_update_ip = request()->ip();
            $data->update();

            return response()->json("Gallery update successfully");
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function galleryDestroy(Request $request)
    {
        try {
            $data = Gallery::find($request->id);
            if (File::exists($data->image)) {
                File::delete($data->image);
                $data->image = null;
            }
            $data->status = 'd';
            $data->last_update_ip = request()->ip();
            $data->deleted_by = Auth::user()->id;
            $data->update();

            $data->delete();
            return response()->json("Gallery delete successfully");
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    //about page
    public function aboutpage()
    {
        if (!checkAccess('about')) {
            return view('error.unauthorize');
        }
        return view('administration.website.about');
    }

    public function getAbout()
    {
        $abouts = AboutPage::first();
        return response()->json($abouts);
    }

    public function aboutUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required'
        ]);
        if ($validator->fails()) return send_error("Validation Error", $validator->errors(), 422);
        try {
            $data         = AboutPage::first();
            $aboutKeys = $request->except('image', 'editor');
            foreach (array_keys($aboutKeys) as $key) {
                $data->$key = $request->$key;
            }
            if ($request->hasFile('image')) {
                if (File::exists($data->image)) {
                    File::delete($data->image);
                }
                $data->image = imageUpload($request, 'image', 'uploads/about', trim($data->title));
            }
            $data->updated_by = Auth::user()->id;
            $data->updated_at = Carbon::now();
            $data->last_update_ip = request()->ip();
            $data->update();

            return response()->json("Aboutpage update successfully");
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }
}
