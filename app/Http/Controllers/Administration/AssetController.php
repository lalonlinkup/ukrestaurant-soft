<?php

namespace App\Http\Controllers\Administration;

use Carbon\Carbon;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\AssetRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AssetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $clauses = "";
        if (!empty($request->brandId)) {
            $clauses .= " and a.brand_id = '$request->brandId'";
        }
        if (!empty($request->unitId)) {
            $clauses .= " and a.unit_id = '$request->unitId'";
        }

        $assets = DB::select("select a.*,
                            b.name as brand_name,
                            u.name as unit_name
                            from assets a
                            left join brands b on b.id = a.brand_id
                            left join units u on u.id = a.unit_id
                            where a.status != 'd' and a.deleted_at is null 
                            $clauses
                            order by a.id desc
                            ");
        return response()->json($assets, 200);
    }

    public function create()
    {
        if (!checkAccess('asset')) {
            return view('error.unauthorize');
        }

        return view('administration.inventory.asset');
    }

    public function store(AssetRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        $exists = Asset::where('name', $request->name)
            ->where('brand_id', $request->brand_id)
            ->exists();
        if ($exists) {
            return response()->json(['status' => true, 'message' => "The asset name must be unique for the given brand!"], 422);
        }
        try {
            $check = DB::table('assets')->where('deleted_at', '!=', NULL)->where('name', $request->name)->first();
            if (!empty($check)) {
                DB::select("UPDATE assets SET deleted_by = NULL, deleted_at = NULL , status = 'a' WHERE id = ?", [$check->id]);
            } else {
                $data     = new Asset();
                $assetKeys = $request->except('id', 'is_active', 'is_serial', 'image');
                foreach (array_keys($assetKeys) as $key) {
                    $data->$key = $request->$key;
                }

                if ($request->hasFile('image')) {
                    $code = make_slug($data->name);
                    $data->image = imageUpload($request, 'image', 'uploads/asset', trim($code));
                }
                $data->is_active      = $request->is_active == 'on' ? 1 : 0;
                $data->is_serial      = $request->is_serial == 'on' ? 1 : 0;
                $data->added_by       = Auth::user()->id;
                $data->last_update_ip = request()->ip();
                $data->save();
            }

            return response()->json(['status' => true, 'message' => 'Asset insert successfully'], 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }
    public function update(AssetRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        $exists = Asset::where('name', $request->name)
            ->where('brand_id', $request->brand_id)
            ->where('id', '!=', $request->id)
            ->exists();
        if ($exists) {
            return response()->json(['status' => true, 'message' => "The asset name must be unique for the given brand!"], 422);
        }
        try {
            $data = Asset::find($request->id);
            $assetKeys = $request->except('id', 'is_active', 'is_serial', 'image');
            foreach (array_keys($assetKeys) as $key) {
                $data->$key = $request->$key;
            }
            if ($request->hasFile('image')) {
                if (File::exists($data->image)) {
                    File::delete($data->image);
                }
                $code = make_slug($data->name);
                $data->image = imageUpload($request, 'image', 'uploads/asset', trim($code));
            }
            $data->is_active      = $request->is_active == 'on' ? 1 : 0;
            $data->is_serial      = $request->is_serial == 'on' ? 1 : 0;
            $data->updated_by     = Auth::user()->id;
            $data->updated_at     = Carbon::now();
            $data->last_update_ip = request()->ip();
            $data->update();

            return response()->json(['status' => true, 'message' => 'Asset update successfully'], 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $data                 = Asset::find($request->id);
            $data->status         = 'd';
            $data->last_update_ip = request()->ip();
            $data->deleted_by     = Auth::user()->id;
            $data->update();

            $data->delete();
            return response()->json("Asset delete successfully", 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function assetList()
    {
        if (!checkAccess('assetList')) {
            return view('error.unauthorize');
        }

        return view('administration.inventory.assetList');
    }

    // Stock
    public function assetStock(Request $request)
    {
        try {
            $stock = Asset::getStock($request);
            
            return response()->json($stock, 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function getIssueAsset(Request $request) 
    {
        $clauses = "";
        
        if (!empty($request->tableId)) {
            $clauses .= " and i.table_id = '$request->tableId'";
        }

        $assets = DB::select("select 
                                a.id,
                                a.code,
                                a.name,
                                a.price,
                                a.origin,
                                concat(a.code, ' - ', a.name) as display_name,
                                id.issue_id,
                                id.asset_id,
                                u.name as unit_name,
                                b.name as brand_name
                            from issue_details id
                            left join issues i on i.id = id.issue_id
                            left join assets a on a.id = id.asset_id
                            left join brands b on b.id = a.brand_id
                            left join units u on u.id = a.unit_id
                            where id.status != 'd' and id.deleted_at is null 
                            $clauses
                            order by a.id desc
                            ");
        return response()->json($assets, 200);
    }
}

