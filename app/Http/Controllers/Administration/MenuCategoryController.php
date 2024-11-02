<?php

namespace App\Http\Controllers\Administration;

use Carbon\Carbon;
use App\Models\MenuCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MenuCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $categories = MenuCategory::where('status', 'a')->latest()->get();
        return response()->json($categories, 200);
    }

    public function create()
    {
        if (!checkAccess('menuCategory')) {
            return view('error.unauthorize');
        }

        return view('administration.restaurant.category');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);
        if ($validator->fails()) return send_error("Validation Error", $validator->errors(), 422);
        $categoryname = MenuCategory::where('name', $request->name)->first();
        if (!empty($categoryname)) return send_error("This name have been already exists", null, 422);
        try {
            $check = DB::table('menu_categories')->where('deleted_at', '!=', NULL)->where('name', $request->name)->first();
            if ($request->hasFile('image')) {
                $image = imageUpload($request, 'image', 'uploads/category', trim($request->name));
            }
            if (!empty($check)) {
                DB::select("UPDATE menu_categories SET deleted_by = NULL, deleted_at = NULL , status = 'a' WHERE id = ?", [$check->id]);
            } else {
                $data = new MenuCategory();
                $data->name = $request->name;
                $data->image = $image;
                $data->slug = make_slug($request->name);
                $data->status = 'a';
                $data->added_by = Auth::user()->id;
                $data->last_update_ip = request()->ip();
                $data->save();
            }

            return response()->json(['status' => true, 'message' => 'Menu Category insert successfully'], 200);
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
        $categoryname = MenuCategory::where('id', '!=', $request->id)->where('name', $request->name)->first();
        if (!empty($categoryname)) return send_error("This name have been already exists", null, 422);

        $data = MenuCategory::find($request->id);

        if ($request->hasFile('image')) {
            $image = imageUpload($request, 'image', 'uploads/category', trim($request->name));
        }
        else{
            $image = $data->image; 
        }
        try {
            $data->name = $request->name;
            $data->slug = make_slug($request->name);
            $data->image = $image;
            $data->updated_by = Auth::user()->id;
            $data->updated_at = Carbon::now();
            $data->last_update_ip = request()->ip();
            $data->update();
            
            return response()->json(['status' => true, 'message' => 'Menu Category update successfully'], 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $data = MenuCategory::find($request->id);
            $data->status = 'd';
            $data->last_update_ip = request()->ip();
            $data->deleted_by = Auth::user()->id;
            $data->update();

            $data->delete();
            return response()->json(['status' => true, 'message' => 'Menu Category delete successfully'], 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }
}
