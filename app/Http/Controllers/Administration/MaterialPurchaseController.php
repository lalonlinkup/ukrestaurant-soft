<?php

namespace App\Http\Controllers\Administration;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\MaterialPurchase;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\MaterialPurchaseRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\MaterialPurchaseDetails;
use Illuminate\Support\Facades\Session;

class MaterialPurchaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (!checkAccess('materialPurchaseList')) {
            return view('error.unauthorize');
        }
        return view('administration.restaurant.materialPurchaseList');
    }

    public function create($id = 0)
    {
        if (!checkAccess('materialPurchase')) {
            return view('error.unauthorize');
        }

        $check = MaterialPurchase::where('id', $id)->first();
        if (empty($check)) {
            if ($id != 0) {
                Session::flash('error', 'Material Purchase not found');
            }
            $id = 0;
        }
        $invoice = invoiceGenerate("MaterialPurchase", 'MP');

        return view('administration.restaurant.materialPurchase', compact('id', 'invoice'));
    }

    public function store(MaterialPurchaseRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        
        $checkInvoice = MaterialPurchase::where('invoice', $request->purchase['invoice'])->first();
        $invoice = $request->purchase['invoice'];
        if (!empty($checkInvoice)) {
            $invoice = invoiceGenerate("MaterialPurchase", 'MP');
        }

        try {
            DB::beginTransaction();
            //Purchase master
            $purchaseKey = $request->purchase;
            $purchase = new MaterialPurchase();
            unset($purchaseKey['id']);
            unset($purchaseKey['invoice']);
            foreach ($purchaseKey as $key => $item) {
                $purchase->$key = $item;
            }
            $purchase->invoice = $invoice;
            $purchase->added_by = Auth::user()->id;
            $purchase->last_update_ip = request()->ip();
            $purchase->save();

            // Purchase detail
            foreach ($request->carts as $cart) {
                unset($cart['name']);
                unset($cart['unitName']);
                $detail = new MaterialPurchaseDetails();
                foreach ($cart as $key => $item) {
                    $detail->$key = $item;
                }
                $detail->material_purchase_id = $purchase->id;
                $detail->added_by = Auth::user()->id;
                $detail->last_update_ip = request()->ip();
                $detail->save();
            }

            DB::commit();
            return response()->json(['status' => true, 'message' => 'Material Purchase insert successfully.!', 'id' => $purchase->id], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function update(MaterialPurchaseRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        
        try {
            DB::beginTransaction();
        
            //Purchase master
            $purchaseKey = $request->purchase;
            $purchase = MaterialPurchase::find($request->purchase['id']);
            unset($purchaseKey['id']);
            foreach ($purchaseKey as $key => $item) {
                $purchase->$key = $item;
            }
            
            $purchase->updated_by = Auth::user()->id;
            $purchase->updated_at = Carbon::now();
            $purchase->last_update_ip = request()->ip();
            $purchase->update();

            // Old Purchase detail
            $olddetail = MaterialPurchaseDetails::where('material_purchase_id', $request->purchase['id'])->get();
            foreach ($olddetail as $item) {
                // old detail delete
                MaterialPurchaseDetails::find($item->id)->forceDelete();
            }

            // Purchase detail
            foreach ($request->carts as $cart) {
                unset($cart['name']);
                unset($cart['unitName']);
                $detail = new MaterialPurchaseDetails();
                foreach ($cart as $key => $item) {
                    $detail->$key = $item;
                }
                $detail->material_purchase_id = $purchase->id;
                $detail->added_by = Auth::user()->id;
                $detail->last_update_ip = request()->ip();
                $detail->save();
            }

            DB::commit();
            return response()->json(['status' => true, 'message' => 'Material Purchase update successfully.', 'id' => $purchase->id], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function get(Request $request)
    {
        try {
            $whereCluase = [];
            if (!empty($request->id)) {
                array_push($whereCluase, ['id', '=', $request->id]);
            }
            if (!empty($request->invoice)) {
                array_push($whereCluase, ['invoice', 'LIKE', $request->invoice . '%']);
            }
            if (!empty($request->supplierId)) {
                array_push($whereCluase, ['supplier_id', '=', $request->supplierId]);
            }
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
                $purchase = MaterialPurchase::with('materialPurchaseDetails', 'supplier', 'employee', 'user')->where($whereCluase)->latest('id');
            } else {
                $purchase = MaterialPurchase::with('supplier', 'employee', 'user')->where($whereCluase)->latest('id');
            }

            if (!empty($request->forSearch)) {
                $purchase = $purchase->limit(20)->get();
            } else {
                $purchase = $purchase->get();
            }

            foreach ($purchase as $key => $item) {
                if ($item->supplier_id != null || $item->supplier_id != '') {
                    $item->supplier = DB::select("select * from suppliers where id = ?", [$item->supplier_id])[0];
                } else {
                    $item->supplier = null;
                }
            }
            return response()->json($purchase);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function details(Request $request) 
    {
        try {
            $whereCluase = "";
            if (!empty($request->supplierId)) {
                $whereCluase .= " AND s.id = '$request->supplierId'";
            }

            if (!empty($request->materialId)) {
                $whereCluase .= " AND m.id = '$request->materialId'";
            }

            if (!empty($request->status)) {
                $whereCluase .= " AND mpd.status = '$request->status'";
            } 

            if (!empty($request->dateFrom) && !empty($request->dateTo)) {
                $whereCluase .= " AND mp.date BETWEEN '$request->dateFrom' AND '$request->dateTo'";
            }
            $details = DB::select("SELECT
                            mpd.*,
                            m.name,
                            mp.invoice,
                            mp.date,
                            s.code as supplier_code,
                            s.name as supplier_name
                        FROM material_purchase_details mpd
                        LEFT JOIN materials m ON m.id = mpd.material_id
                        LEFT JOIN material_purchases mp ON mp.id = mpd.material_purchase_id
                        LEFT JOIN suppliers s ON s.id = mp.supplier_id
                        WHERE mpd.status != 'd' 
                        $whereCluase");

            return response()->json($details);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function invoicePrint($id)
    {
        if (!checkAccess('materialPurchaseInvoice')) {
            return view('error.unauthorize');
        }

        return view("administration.restaurant.materialPurchaseInvoice", compact('id'));
    }

    public function destroy(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = MaterialPurchase::find($request->id);
            $data->status = 'd';
            $data->last_update_ip = request()->ip();
            $data->deleted_by = Auth::user()->id;
            $data->update();

            //old purchase detail
            $details = MaterialPurchaseDetails::where('material_purchase_id', $request->id)->get();
            foreach ($details as $item) {
                // old details delete
                $detail = MaterialPurchaseDetails::find($item->id);
                $detail->status = 'd';
                $detail->last_update_ip = request()->ip();
                $detail->deleted_at = Carbon::now();
                $detail->deleted_by = Auth::user()->id;
                $detail->update();
            }

            $data->delete();
            DB::commit();
            return response()->json(['status' => true, 'message' => 'Material Purchase delete successfully.'], 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
            DB::rollBack();
        }
    }
}