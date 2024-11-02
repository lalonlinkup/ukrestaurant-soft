<?php

namespace App\Http\Controllers\Administration;

use Carbon\Carbon;
use App\Models\IssueReturn;
use Illuminate\Http\Request;
use App\Models\IssueReturnDetails;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\IssueReturnRequest;

class IssueReturnController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (!checkAccess('issueReturnList')) {
            return view('error.unauthorize');
        }
        return view('administration.inventory.issueReturnList');
    }

    public function create()
    {
        if (!checkAccess('issueReturn')) {
            return view('error.unauthorize');
        }
        return view('administration.inventory.issueReturn');
    }

    public function getAssetForReturn(Request $request)
    {
        $clauses = "";
        if (!empty($request->roomId)) {
            $clauses .= " and i.room_id = '$request->roomId'";
        }

        $assets = DB::select("select 
                                a.id,
                                a.name,
                                a.code,
                                a.price,
                                b.name as brand_name
                            from issue_details idt
                            left join issues i on i.id = idt.issue_id
                            left join assets a on a.id = idt.asset_id
                            left join brands b on b.id = a.brand_id
                            where idt.status = 'a' and idt.deleted_at is null 
                            $clauses
                        ");
        return response()->json($assets, 200);
    }

    public function store(IssueReturnRequest $request)
    {

        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
       
        try {
            DB::beginTransaction();
            //Purchase master
            $issueReturnKey = $request->issueReturn;
            $issueReturn = new IssueReturn();
            unset($issueReturnKey['id']);
            foreach ($issueReturnKey as $key => $item) {
                $issueReturn->$key = $item;
            }
            $issueReturn->added_by = Auth::user()->id;
            $issueReturn->last_update_ip = request()->ip();
            $issueReturn->save();

            // Purchase detail
            foreach ($request->carts as $cart) {
                unset($cart['code']);
                unset($cart['name']);
                unset($cart['brandName']);
                $detail = new IssueReturnDetails();
                foreach ($cart as $key => $item) {
                    $detail->$key = $item;
                }
                $detail->issue_return_id = $issueReturn->id;
                $detail->added_by = Auth::user()->id;
                $detail->last_update_ip = request()->ip();
                $detail->save();
            }

            DB::commit();
            return response()->json(['status' => true, 'message' => 'Issue return insert successfully.!', 'id' => $issueReturn->id], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function invoice($id) 
    {
        if (!checkAccess('issueInvoice')) {
            return view('error.unauthorize');
        }

        return view("administration.inventory.issueReturnInvoice", compact('id'));
    }

    public function get(Request $request)
    {
        try {
            $whereCluase = [];
            if (!empty($request->id)) {
                array_push($whereCluase, ['id', '=', $request->id]);
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
                $issue = IssueReturn::with('issueReturnDetails', 'room', 'user')->where($whereCluase)->latest('id');
            } else {
                $issue = IssueReturn::with('room', 'user')->where($whereCluase)->latest('id');
            }

            if (!empty($request->forSearch)) {
                $issue = $issue->limit(20)->get();
            } else {
                $issue = $issue->get();
            }

            foreach ($issue as $key => $item) {
                if ($item->room_id != null || $item->room_id != '') {
                    $item->room = DB::select("select * from rooms where id = ?", [$item->room_id])[0];
                } else {
                    $item->room = null;
                }
            }
            return response()->json($issue);
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
                $whereCluase .= " AND ird.status = '$request->status'";
            } 

            if (!empty($request->dateFrom) && !empty($request->dateTo)) {
                $whereCluase .= " AND ir.date BETWEEN '$request->dateFrom' AND '$request->dateTo'";
            }
            $details = DB::select("SELECT
                            ird.*,
                            a.code,
                            a.name,
                            ir.date,
                            r.code as room_code,
                            r.name as room_name
                        FROM issue_return_details ird
                        LEFT JOIN assets a ON a.id = ird.asset_id
                        LEFT JOIN issue_returns ir ON ir.id = ird.issue_return_id
                        LEFT JOIN rooms r ON r.id = ir.room_id
                        WHERE ird.status != 'd' 
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
            $data = IssueReturn::find($request->id);
            $data->status = 'd';
            $data->last_update_ip = request()->ip();
            $data->deleted_by = Auth::user()->id;
            $data->update();

            //old issue detail
            $details = IssueReturnDetails::where('issue_return_id', $request->id)->get();
            foreach ($details as $item) {
                // old detail delete
                $detail = IssueReturnDetails::find($item->id);
                $detail->status = 'd';
                $detail->last_update_ip = request()->ip();
                $detail->deleted_at = Carbon::now();
                $detail->deleted_by = Auth::user()->id;
                $detail->update();
            }

            $data->delete();
            DB::commit();
            return response()->json(['status' => true, 'message' => 'Issue Return delete successfully.'], 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
            DB::rollBack();
        }
    }

}
