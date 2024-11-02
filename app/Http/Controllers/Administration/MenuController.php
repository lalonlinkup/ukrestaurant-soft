<?php

namespace App\Http\Controllers\Administration;

use Carbon\Carbon;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Requests\MenuRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $clauses = "";
        if (!empty($request->categoryId)) {
            $clauses .= " and m.menu_category_id = '$request->categoryId'";
        }
        if (!empty($request->unitId)) {
            $clauses .= " and m.unit_id = '$request->unitId'";
        }

        $menus = DB::select("select m.*,
                            c.name as category_name,
                            u.name as unit_name
                            from menus m
                            left join menu_categories c on c.id = m.menu_category_id
                            left join units u on u.id = m.unit_id
                            where m.status != 'd' and m.deleted_at is null 
                            $clauses
                            order by m.id desc
                            ");

                            foreach ($menus as $menu) {
                                $menu->recipes =  DB::select("
                                    select 
                                        r.*,
                                        m.name as material_name
                                    from recipes r
                                    left join materials m on m.id = r.material_id
                                    where r.menu_id = '$menu->id' 
                                    and r.status != 'd'
                                ");
                            }
        return response()->json($menus, 200);
    }

    public function create()
    {
        if (!checkAccess('menu')) {
            return view('error.unauthorize');
        }

        return view('administration.restaurant.create');
    }

    public function store(MenuRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        $exists = Menu::where('name', $request->name)
            ->where('menu_category_id', $request->menu_category_id)
            ->exists();
        if ($exists) {
            return response()->json(['status' => true, 'message' => "The menu name must be unique for the given category!"], 422);
        }
        try {
            DB::beginTransaction();
            $materials = json_decode($request->materials, true);
            $check = DB::table('menus')->where('deleted_at', '!=', NULL)->where('name', $request->name)->first();

            if (!empty($check)) {
                DB::select("UPDATE menus SET deleted_by = NULL, deleted_at = NULL , status = 'a' WHERE id = ?", [$check->id]);
                DB::select("UPDATE recipes SET deleted_by = NULL, deleted_at = NULL , status = 'a' WHERE menu_id = ?", [$check->id]);
            } else {
                $data     = new Menu();
                $menuKeys = $request->except('id', 'image', 'materials');
                foreach (array_keys($menuKeys) as $key) {
                    $data->$key = $request->$key;
                }

                if ($request->hasFile('image')) {
                    $data->image = imageUpload($request, 'image', 'uploads/menu', trim($data->code));
                }
                $data->slug           = make_slug($request->name);
                $data->added_by       = Auth::user()->id;
                $data->last_update_ip = request()->ip();
                $data->save();

                // material detail
                foreach ($materials as $material) {
                    unset($material['name']);
                    $detail = new Recipe();
                    foreach ($material as $key => $item) {
                        $detail->$key = $item;
                    }
                    $detail->menu_id = $data->id;
                    $detail->added_by = Auth::user()->id;
                    $detail->last_update_ip = request()->ip();
                    $detail->save();
                }
            }


            DB::commit();
            return response()->json(['status' => true, 'message' => 'Menu insert successfully', 'code' => generateCode('Menu', 'M')], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return send_error("Something went wrong", $th->getMessage());
        }
    }
    public function update(MenuRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        $materials = json_decode($request->materials, true);
        $exists = Menu::where('name', $request->name)
            ->where('menu_category_id', $request->menu_category_id)
            ->where('id', '!=', $request->id)
            ->exists();
        if ($exists) {
            return response()->json(['status' => true, 'message' => "The menu name must be unique for the given category!"], 422);
        }
        try {
            DB::beginTransaction();
            $data = Menu::find($request->id);
            $data->code = generateCode("Menu", 'M');
            $menuKeys = $request->except('id', 'image', 'materials');
            foreach (array_keys($menuKeys) as $key) {
                $data->$key = $request->$key;
            }
            if ($request->hasFile('image')) {
                if (File::exists($data->image)) {
                    File::delete($data->image);
                }
                $data->image = imageUpload($request, 'image', 'uploads/menu', trim($data->code));
            }
            $data->slug           = make_slug($request->name);
            $data->updated_by     = Auth::user()->id;
            $data->updated_at     = Carbon::now();
            $data->last_update_ip = request()->ip();
            $data->update();

            // Old Recipe
            $oldRecipes = Recipe::where('menu_id', $request->id)->get();
            foreach ($oldRecipes as $item) {
                Recipe::find($item->id)->forceDelete();
            }
 
            // material detail
            foreach ($materials as $material) {
                unset($material['name']);
                $detail = new Recipe();
                foreach ($material as $key => $item) {
                    $detail->$key = $item;
                }
                $detail->menu_id = $data->id;
                $detail->added_by = Auth::user()->id;
                $detail->last_update_ip = request()->ip();
                $detail->save();
            }

            DB::commit();
            return response()->json(['status' => true, 'message' => 'Menu update successfully', 'code' => generateCode('Menu', 'M')], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $data                 = Menu::find($request->id);
            $data->status         = 'd';
            $data->last_update_ip = request()->ip();
            $data->deleted_by     = Auth::user()->id;
            $data->update();

            $data->delete();

            $recipes = Recipe::where('menu_id', $request->id)->get();
            foreach ($recipes as $item) {
                $item->status         = 'd';
                $item->last_update_ip = request()->ip();
                $item->deleted_by     = Auth::user()->id;
                $item->update();

                $item->delete();
            }

            return response()->json("Menu delete successfully", 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function updateStatus(Request $request)
    {
        try {
            $data                 = Menu::find($request->id);
            $data->status         = $data->status == 'a' ? 'p' : 'a';
            $data->last_update_ip = request()->ip();
            $data->updated_at     = Carbon::now();
            $data->update();

            $recipes = Recipe::where('menu_id', $request->id)->get();
            foreach ($recipes as $item) {
                $item->status         = $item->status == 'a' ? 'p' : 'a';
                $item->last_update_ip = request()->ip();
                $item->updated_at     = Carbon::now();
                $item->update();
            }
            
            return response()->json("Menu Status Update.!", 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function menuList()
    {
        if (!checkAccess('menuList')) {
            return view('error.unauthorize');
        }

        return view('administration.restaurant.list');
    }
}
