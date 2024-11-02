<?php

namespace App\Http\Controllers\Administration;

use Carbon\Carbon;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Requests\MaterialRequest;
use App\Models\Production;

class MaterialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $clauses = "";

        if (!empty($request->unitId)) {
            $clauses .= " and m.unit_id = '$request->unitId'";
        }

        $materials = DB::select("select m.*,
                            u.name as unit_name
                            from materials m
                            left join units u on u.id = m.unit_id
                            where m.status != 'd' and m.deleted_at is null 
                            $clauses
                            order by m.id desc
                            ");
        return response()->json($materials, 200);
    }

    public function create()
    {
        if (!checkAccess('material')) {
            return view('error.unauthorize');
        }

        return view('administration.restaurant.material');
    }

    public function store(MaterialRequest $request)
    {
        
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        try {
            $data         = new Material();
            $materialKeys = $request->except('image', 'id');
            foreach (array_keys($materialKeys) as $key) {
                $data->$key = $request->$key;
            }
            if ($request->hasFile('image')) {
                $data->image = imageUpload($request, 'image', 'uploads/material', trim($data->title));
            }
            $data->added_by = Auth::user()->id;
            $data->last_update_ip = request()->ip();
            $data->save();
            return response()->json("Material insert successfully");
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }
    public function update(MaterialRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        try {
            $data         = Material::find($request->id);
            $materialKeys = $request->except('image', 'id');
            foreach (array_keys($materialKeys) as $key) {
                $data->$key = $request->$key;
            }
            if ($request->hasFile('image')) {
                if (File::exists($data->image)) {
                    File::delete($data->image);
                }
                $data->image = imageUpload($request, 'image', 'uploads/material', trim($data->title));
            }
            $data->updated_by = Auth::user()->id;
            $data->updated_at = Carbon::now();
            $data->last_update_ip = request()->ip();
            $data->update();

            return response()->json("Material update successfully");
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $data = Material::find($request->id);
            if (File::exists($data->image)) {
                File::delete($data->image);
                $data->image = null;
            }
            $data->status = 'd';
            $data->last_update_ip = request()->ip();
            $data->deleted_by = Auth::user()->id;
            $data->update();

            $data->delete();
            return response()->json("Material delete successfully");
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    // production method 
    public function productionList()
    {
        if (!checkAccess('productionList')) {
            return view('error.unauthorize');
        }

        return view('administration.restaurant.productionList');
    }

    public function getProduction(Request $request)
    {
        try {
            $whereCluase = [];
            if (!empty($request->id)) {
                array_push($whereCluase, ['id', '=', $request->id]);
            }
            if (!empty($request->invoice)) {
                array_push($whereCluase, ['invoice', 'LIKE', $request->invoice . '%']);
            }
            // if (!empty($request->customerId)) {
            //     array_push($whereCluase, ['customer_id', '=', $request->customerId]);
            // }
            if (!empty($request->userId)) {
                array_push($whereCluase, ['added_by', '=', $request->userId]);
            }
            if (!empty($request->status)) {
                array_push($whereCluase, ['status', '=', $request->status]);
            } else {
                array_push($whereCluase, ['status', '!=', 'd']);
            }
            if (!empty($request->dateFrom) && !empty($request->dateTo)) {
                array_push($whereCluase, ['date', '>=', $request->dateFrom]);
                array_push($whereCluase, ['date', '<=', $request->dateTo]);
            }

            if ((!empty($request->recordType) && $request->recordType == 'with') || !empty($request->id)) {
                $productions = Production::with('productionDetails', 'order', 'user')->where($whereCluase)->latest('id');
            } else {
                $productions = Production::with('order', 'user')->where($whereCluase)->latest('id');
            }

            if (!empty($request->forSearch)) {
                $productions = $productions->limit(20)->get();
            } else {
                $productions = $productions->get();
            }

            foreach ($productions as $key => $item) {
                if ($item->order->customer_id != null || $item->order->customer_id != '') {
                    $item->order->customer = DB::select("select * from customers where id = ?", [$item->order->customer_id])[0];
                } else {
                    $item->order->customer = null;
                }
            }
            return response()->json($productions);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function productionDetails(Request $request) 
    {
        try {
            $whereCluase = "";
            if (!empty($request->customerId)) {
                $whereCluase .= " AND c.id = '$request->customerId'";
            }

            if (!empty($request->materialId)) {
                $whereCluase .= " AND m.id = '$request->materialId'";
            }

            if (!empty($request->status)) {
                $whereCluase .= " AND pd.status = '$request->status'";
            } 

            if (!empty($request->dateFrom) && !empty($request->dateTo)) {
                $whereCluase .= " AND o.date BETWEEN '$request->dateFrom' AND '$request->dateTo'";
            }
            $details = DB::select("SELECT
                            pd.*,
                            m.name,
                            o.invoice,
                            o.date,
                            o.customer_id,
                            ifnull(c.code, 'Cash Guest') as customer_code,
                            ifnull(c.name, o.customer_name) as customer_name
                        FROM production_details pd
                        LEFT JOIN materials m ON m.id = pd.material_id
                        LEFT JOIN productions p ON p.id = pd.production_id
                        LEFT JOIN orders o ON o.id = p.order_id
                        LEFT JOIN customers c ON c.id = o.customer_id
                        WHERE pd.status != 'd' 
                        $whereCluase");

            return response()->json($details);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function stock() 
    {
        if (!checkAccess('materialStock')) {
            return view('error.unauthorize');
        }

        return view('administration.restaurant.materialStock');
    }

    public function getStock(Request $request)
    {
        try {
            $stock = Material::getMaterialStock($request);
            
            return response()->json($stock, 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }
}
