<?php

namespace App\Http\Controllers\Administration;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Requests\SupplierRequest;

class SupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $whereCluase = [
            ['type', '!=', 'G']
        ];
        if (!empty($request->districtId)) {
            array_push($whereCluase, ['district_id', '=', $request->districtId]);
        }
        if (!empty($request->forSearch)) {
            $suppliers = Supplier::with('district')->where($whereCluase)->limit(20)->latest()->get();
        } elseif (!empty($request->name)) {
            $suppliers = Supplier::with('district')->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->name . '%')
                    ->orWhere('code', 'like', '%' . $request->name . '%')
                    ->orWhere('phone', 'like', '%' . $request->name . '%');
            })->get();
        } else {
            $suppliers = Supplier::with('district')->where($whereCluase)->latest()->get();
        }

        return response()->json($suppliers);
    }

    public function create()
    {
        if (!checkAccess('supplier')) {
            return view('error.unauthorize');
        }

        return view('administration.settings.supplier.index');
    }

    public function store(SupplierRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        $supunique = Supplier::where('phone', $request->phone)->first();
        if (!empty($supunique)) return send_error("This phone have been already taken", null, 422);
        try {
            $check = DB::table('suppliers')->where('deleted_at', '!=', NULL)->where('phone', $request->phone)->first();
            if (!empty($check)) {
                DB::select("UPDATE suppliers SET deleted_by = NULL, deleted_at = NULL , status = 'a' WHERE id = ?", [$check->id]);
            } else {
                $supplier_code = DB::select("select code from suppliers where code = ? ", [$request->code]);
                if (count($supplier_code) > 0) {
                    $code = generateCode("Supplier", 'S');
                } else {
                    $code = $request->code;
                }
                $data         = new Supplier();
                $data->code   = $code;
                $supplierKeys = $request->except('image', 'id', 'code');
                foreach (array_keys($supplierKeys) as $key) {
                    $data->$key = $request->$key;
                }
                $data->type           = 'retail';
                if ($request->hasFile('image')) {
                    $data->image = imageUpload($request, 'image', 'uploads/supplier', trim($request->code));
                }
                $data->added_by        = Auth::user()->id;
                $data->last_update_ip  = request()->ip();
                $data->save();
            }

            return response()->json("Supplier insert successfully");
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }
    public function update(SupplierRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        $supunique = Supplier::where('id', '!=', $request->id)->where('phone', $request->phone)->first();
        if (!empty($supunique)) return send_error("This name have been already taken", null, 422);
        try {
            $supplier_code = DB::select("select code from suppliers where code = ? and id != ?", [$request->code, $request->id]);
            if (count($supplier_code) > 0) return send_error("This supplier code already exists", null, 422);

            $data                 = Supplier::find($request->id);
            $supplierKeys = $request->except('image', 'id');
            foreach (array_keys($supplierKeys) as $key) {
                $data->$key = $request->$key;
            }
            if ($request->hasFile('image')) {
                if (File::exists($data->image)) {
                    File::delete($data->image);
                }
                $data->image = imageUpload($request, 'image', 'uploads/supplier', trim($request->code));
            }
            $data->updated_by = Auth::user()->id;
            $data->updated_at = Carbon::now();
            $data->last_update_ip = request()->ip();
            $data->update();

            return response()->json("Supplier update successfully");
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $data = Supplier::find($request->id);
            if (File::exists($data->image)) {
                File::delete($data->image);
                $data->image = null;
            }
            $data->status = 'd';
            $data->last_update_ip = request()->ip();
            $data->deleted_by = Auth::user()->id;
            $data->update();

            $data->delete();
            return response()->json("Supplier delete successfully");
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function supplierList()
    {
        return view('administration.settings.supplier.supplierList');
    }
}
