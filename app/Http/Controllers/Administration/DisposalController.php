<?php

namespace App\Http\Controllers\Administration;

use Carbon\Carbon;
use App\Models\Disposal;
use Illuminate\Http\Request;
use App\Models\DisposalDetails;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\DisposalRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DisposalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (!checkAccess('disposalList')) {
            return view('error.unauthorize');
        }
        return view('administration.inventory.disposalList');
    }

    public function create($id = 0)
    {
        if (!checkAccess('disposal')) {
            return view('error.unauthorize');
        }

        $check = Disposal::where('id', $id)->first();
        if (empty($check)) {
            if ($id != 0) {
                Session::flash('error', 'Disposal not found');
            }
            $id = 0;
        }
        $invoice = invoiceGenerate("Disposal", 'D');

        return view('administration.inventory.disposal', compact('id', 'invoice'));
    }

    public function store(DisposalRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        
        $checkInvoice = Disposal::where('invoice', $request->disposal['invoice'])->first();
        $invoice = $request->disposal['invoice'];
        if (!empty($checkInvoice)) {
            $invoice = invoiceGenerate("Disposal", 'D');
        }

        try {
            DB::beginTransaction();
            //Disposal master
            $disposalKey = $request->disposal;
            $disposal = new Disposal();
            unset($disposalKey['id']);
            unset($disposalKey['invoice']);
            foreach ($disposalKey as $key => $item) {
                $disposal->$key = $item;
            }
            $disposal->invoice = $invoice;
            $disposal->added_by = Auth::user()->id;
            $disposal->last_update_ip = request()->ip();
            $disposal->save();

            // Purchase detail
            foreach ($request->carts as $cart) {
                unset($cart['code']);
                unset($cart['name']);
                unset($cart['brandName']);
                $detail = new DisposalDetails();
                foreach ($cart as $key => $item) {
                    $detail->$key = $item;
                }
                $detail->disposal_id = $disposal->id;
                $detail->added_by = Auth::user()->id;
                $detail->last_update_ip = request()->ip();
                $detail->save();
            }

            DB::commit();
            return response()->json(['status' => true, 'message' => 'Disposal insert successfully.!', 'id' => $disposal->id], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function update(DisposalRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        
        try {
            DB::beginTransaction();
        
            //Purchase master
            $disposalKey = $request->disposal;
            $disposal = Disposal::find($request->disposal['id']);
            unset($disposalKey['id']);
            foreach ($disposalKey as $key => $item) {
                $disposal->$key = $item;
            }
            
            $disposal->updated_by = Auth::user()->id;
            $disposal->updated_at = Carbon::now();
            $disposal->last_update_ip = request()->ip();
            $disposal->update();

            // Old Purchase detail
            $olddetail = DisposalDetails::where('disposal_id', $request->disposal['id'])->get();
            foreach ($olddetail as $item) {
                // old detail delete
                DisposalDetails::find($item->id)->forceDelete();
            }

            // Purchase detail
            foreach ($request->carts as $cart) {
                unset($cart['code']);
                unset($cart['name']);
                unset($cart['brandName']);
                $detail = new DisposalDetails();
                foreach ($cart as $key => $item) {
                    $detail->$key = $item;
                }
                $detail->disposal_id = $disposal->id;
                $detail->added_by = Auth::user()->id;
                $detail->last_update_ip = request()->ip();
                $detail->save();
            }

            DB::commit();
            return response()->json(['status' => true, 'message' => 'Purchase update successfully.', 'id' => $disposal->id], 200);
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
            if (!empty($request->roomId)) {
                array_push($whereCluase, ['room_id', '=', $request->roomId]);
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
                $disposal = Disposal::with('disposalDetails', 'room', 'user')->where($whereCluase)->latest('id');
            } else {
                $disposal = Disposal::with('room', 'user')->where($whereCluase)->latest('id');
            }

            if (!empty($request->forSearch)) {
                $disposal = $disposal->limit(20)->get();
            } else {
                $disposal = $disposal->get();
            }

            foreach ($disposal as $key => $item) {
                if ($item->supplier_id != null || $item->supplier_id != '') {
                    $item->supplier = DB::select("select * from suppliers where id = ?", [$item->supplier_id])[0];
                } else {
                    $item->supplier = null;
                }
            }
            return response()->json($disposal);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function details(Request $request) 
    {
        try {
            $whereCluase = "";
            if (!empty($request->roomId)) {
                $whereCluase .= " AND r.id = '$request->roomId'";
            }

            if (!empty($request->assetId)) {
                $whereCluase .= " AND a.id = '$request->assetId'";
            }

            if (!empty($request->status)) {
                $whereCluase .= " AND dd.status = '$request->status'";
            } 

            if (!empty($request->dateFrom) && !empty($request->dateTo)) {
                $whereCluase .= " AND d.date BETWEEN '$request->dateFrom' AND '$request->dateTo'";
            }
            $details = DB::select("SELECT
                            dd.*,
                            a.code,
                            a.name,
                            d.invoice,
                            d.date,
                            r.code as room_code,
                            r.name as room_name
                        FROM disposal_details dd
                        LEFT JOIN assets a ON a.id = dd.asset_id
                        LEFT JOIN disposals d ON d.id = dd.disposal_id
                        LEFT JOIN rooms r ON r.id = d.room_id
                        WHERE dd.status != 'd' 
                        $whereCluase");

            return response()->json($details);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = Disposal::find($request->id);
            $data->status = 'd';
            $data->last_update_ip = request()->ip();
            $data->deleted_by = Auth::user()->id;
            $data->update();

            //old disposal detail
            $details = DisposalDetails::where('disposal_id', $request->id)->get();
            foreach ($details as $item) {
                // old detail delete
                $detail = DisposalDetails::find($item->id);
                $detail->status = 'd';
                $detail->last_update_ip = request()->ip();
                $detail->deleted_at = Carbon::now();
                $detail->deleted_by = Auth::user()->id;
                $detail->update();
            }

            $data->delete();
            DB::commit();
            return response()->json(['status' => true, 'message' => 'Purchase delete successfully.'], 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
            DB::rollBack();
        }
    }
}