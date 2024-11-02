<?php

namespace App\Http\Controllers\Administration;

use Carbon\Carbon;
use App\Models\Issue;
use App\Models\IssueDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\IssueRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class IssueController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (!checkAccess('issueList')) {
            return view('error.unauthorize');
        }
        return view('administration.inventory.issueList');
    }

    public function create($id = 0)
    {
        if (!checkAccess('issue')) {
            return view('error.unauthorize');
        }

        $check = Issue::where('id', $id)->first();
        if (empty($check)) {
            if ($id != 0) {
                Session::flash('error', 'Issue not found');
            }
            $id = 0;
        }
        $invoice = invoiceGenerate("Issue", 'I');

        return view('administration.inventory.create', compact('id', 'invoice'));
    }

    public function store(IssueRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        
        $checkInvoice = Issue::where('invoice', $request->issue['invoice'])->first();
        $invoice = $request->issue['invoice'];
        if (!empty($checkInvoice)) {
            $invoice = invoiceGenerate("Purchase", 'P');
        }

        try {
            DB::beginTransaction();
            //Purchase master
            $issueKey = $request->issue;
            $issue = new Issue();
            unset($issueKey['id']);
            unset($issueKey['invoice']);
            foreach ($issueKey as $key => $item) {
                $issue->$key = $item;
            }
            $issue->invoice = $invoice;
            $issue->added_by = Auth::user()->id;
            $issue->last_update_ip = request()->ip();
            $issue->save();

            // Purchase detail
            foreach ($request->carts as $cart) {
                unset($cart['code']);
                unset($cart['name']);
                unset($cart['brandName']);
                $detail = new IssueDetails();
                foreach ($cart as $key => $item) {
                    $detail->$key = $item;
                }
                $detail->issue_id = $issue->id;
                $detail->added_by = Auth::user()->id;
                $detail->last_update_ip = request()->ip();
                $detail->save();
            }

            DB::commit();
            return response()->json(['status' => true, 'message' => 'Purchase insert successfully.!', 'id' => $issue->id], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function update(IssueRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        
        try {
            DB::beginTransaction();
        
            //Purchase master
            $issueKey = $request->issue;
            $issue = Issue::find($request->issue['id']);
            unset($issueKey['id']);
            foreach ($issueKey as $key => $item) {
                $issue->$key = $item;
            }
            
            $issue->updated_by = Auth::user()->id;
            $issue->updated_at = Carbon::now();
            $issue->last_update_ip = request()->ip();
            $issue->update();

            // Old Purchase detail
            $olddetail = IssueDetails::where('issue_id', $request->issue['id'])->get();
            foreach ($olddetail as $item) {
                // old detail delete
                IssueDetails::find($item->id)->forceDelete();
            }

            // Purchase detail
            foreach ($request->carts as $cart) {
                unset($cart['code']);
                unset($cart['name']);
                unset($cart['brandName']);
                $detail = new IssueDetails();
                foreach ($cart as $key => $item) {
                    $detail->$key = $item;
                }
                $detail->issue_id = $issue->id;
                $detail->added_by = Auth::user()->id;
                $detail->last_update_ip = request()->ip();
                $detail->save();
            }

            DB::commit();
            return response()->json(['status' => true, 'message' => 'Issue update successfully.', 'id' => $issue->id], 200);
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
                $issue = Issue::with('issueDetails', 'room', 'user')->where($whereCluase)->latest('id');
            } else {
                $issue = Issue::with('room', 'user')->where($whereCluase)->latest('id');
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
                $whereCluase .= " AND id.status = '$request->status'";
            } 

            if (!empty($request->dateFrom) && !empty($request->dateTo)) {
                $whereCluase .= " AND p.date BETWEEN '$request->dateFrom' AND '$request->dateTo'";
            }
            $details = DB::select("SELECT
                            id.*,
                            a.code,
                            a.name,
                            p.invoice,
                            p.date,
                            r.code as room_code,
                            r.name as room_name
                        FROM issue_details id
                        LEFT JOIN assets a ON a.id = id.asset_id
                        LEFT JOIN issues p ON p.id = id.issue_id
                        LEFT JOIN rooms r ON r.id = r.room_id
                        WHERE id.status != 'd' 
                        $whereCluase");

            return response()->json($details);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function invoicePrint($id)
    {
        if (!checkAccess('issueInvoice')) {
            return view('error.unauthorize');
        }

        return view("administration.inventory.issueInvoice", compact('id'));
    }

    public function destroy(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = Issue::find($request->id);
            $data->status = 'd';
            $data->last_update_ip = request()->ip();
            $data->deleted_by = Auth::user()->id;
            $data->update();

            //old issue detail
            $details = IssueDetails::where('issue_id', $request->id)->get();
            foreach ($details as $item) {
                // old detail delete
                $detail = IssueDetails::find($item->id);
                $detail->status = 'd';
                $detail->last_update_ip = request()->ip();
                $detail->deleted_at = Carbon::now();
                $detail->deleted_by = Auth::user()->id;
                $detail->update();
            }

            $data->delete();
            DB::commit();
            return response()->json(['status' => true, 'message' => 'Issue delete successfully.'], 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
            DB::rollBack();
        }
    }
}
