<?php

namespace App\Http\Controllers\Administration;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Customer;
use App\Models\OrderDetails;
use App\Models\OrderTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\OrderRequest;
use App\Http\Controllers\Controller;
use App\Models\Production;
use App\Models\ProductionDetail;
use App\Models\Recipe;
use App\Models\TableBooking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (!checkAccess('orderList')) {
            return view('error.unauthorize');
        }
        return view('administration.restaurant.orderList');
    }

    public function pending()
    {
        if (!checkAccess('pendingOrder')) {
            return view('error.unauthorize');
        }
        return view('administration.restaurant.pendingOrder');
    }

    public function tableBooking()
    {
        if (!checkAccess('tableBooking')) {
            return view('error.unauthorize');
        }
        return view('administration.restaurant.tableBookingList');
    }

    public function create($id = 0)
    {
        if (!checkAccess('order')) {
            return view('error.unauthorize');
        }

        $check = Order::where('id', $id)->first();
        if (empty($check)) {
            if ($id != 0) {
                Session::flash('error', 'Order not found');
            }
            $id = 0;
        }
        $invoice = invoiceGenerate("Order", 'O');

        return view('administration.restaurant.order', compact('id', 'invoice'));
    }

    public function store(OrderRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        if ($request->customer['type'] == 'G' && $request->order['paid'] < $request->order['total']) {
            return send_error("Cash Guest can not due", null, 422);
        }

        $checkInvoice = Order::where('invoice', $request->order['invoice'])->first();
        $invoice = $request->order['invoice'];
        if (!empty($checkInvoice)) {
            $invoice = invoiceGenerate("Order", 'O');
        }

        try {
            DB::beginTransaction();

            //customer
            if ($request->customer['type'] != 'G') {
                $check = Customer::where('phone', $request->customer['phone'])->first();
                if (empty($check)) {
                    $customer = new Customer();
                    $customer->code = generateCode("Customer", "C");
                    $customer->name = $request->customer['name'];
                    $customer->phone = $request->customer['phone'];
                    $customer->address = $request->customer['address'];
                    $customer->added_by = Auth::user()->id;
                    $customer->last_update_ip = request()->ip();
                    $customer->save();
                    $customerId = $customer->id;
                } else {
                    $customerId = $check->id;
                }
            }

            //Order master
            $orderKey = $request->order;
            $order = new Order();
            unset($orderKey['id']);
            unset($orderKey['invoice']);
            foreach ($orderKey as $key => $item) {
                $order->$key = $item;
            }
            $order->invoice = $invoice;
            if ($request->customer['type'] != 'G') {
                $order->customer_id = $customerId;
            } else {
                $order->customer_id = NULL;
                $order->customer_name = $request->customer['name'];
                $order->customer_phone = $request->customer['phone'];
                $order->customer_address = $request->customer['address'];
            }
            $order->table_id = $request->tableCart[0]['table_id'];
            $order->order_type = 'Order';
            $order->status = 'a';
            $order->added_by = Auth::user()->id;
            $order->last_update_ip = request()->ip();
            $order->save();

            // Order detail
            foreach ($request->carts as $cart) {
                unset($cart['code']);
                unset($cart['name']);
                $detail = new OrderDetails();
                foreach ($cart as $key => $item) {
                    $detail->$key = $item;
                }
                $detail->order_id = $order->id;
                $detail->added_by = Auth::user()->id;
                $detail->last_update_ip = request()->ip();
                $detail->save();

                $recipes = Recipe::where('menu_id', $cart['menu_id'])->get();
                if (isset($recipes)) {
                    $production = new Production();
                    $production->invoice = invoiceGenerate('Production', 'PR');
                    $production->date = date('Y-m-d');
                    $production->order_id = $order->id;
                    $production->total = $recipes->sum('total');
                    $production->description = 'Order production invoice -' . $invoice;
                    $production->status = 'a';
                    $production->added_by = Auth::user()->id;
                    $production->last_update_ip = request()->ip();
                    $production->save();

                    foreach ($recipes as $item) {
                        $productionDetails = new ProductionDetail();
                        $productionDetails->production_id = $production->id;
                        $productionDetails->material_id = $item->material_id;
                        $productionDetails->quantity = $item->quantity;
                        $productionDetails->price = $item->price;
                        $productionDetails->total = $item->total;
                        $productionDetails->status = 'a';
                        $productionDetails->added_by = Auth::user()->id;
                        $productionDetails->last_update_ip = request()->ip();
                        $productionDetails->save();
                    }
                }
            }

            DB::commit();
            return response()->json(['status' => true, 'message' => 'Order insert successfully', 'id' => $order->id], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function update(OrderRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        if ($request->customer['type'] == 'G' && $request->order['paid'] < $request->order['total']) {
            return send_error("Cash Guest can not due", null, 422);
        }

        try {
            DB::beginTransaction();
            //customer
            if ($request->customer['type'] != 'G') {
                $check = Customer::where('phone', $request->customer['phone'])->first();
                if (empty($check)) {
                    $customer = new Customer();
                    $customer->code = generateCode("Customer", "C");
                    $customer->name = $request->customer['name'];
                    $customer->phone = $request->customer['phone'];
                    $customer->address = $request->customer['address'];
                    $customer->added_by = Auth::user()->id;
                    $customer->last_update_ip = request()->ip();
                    $customer->save();
                    $customerId = $customer->id;
                } else {
                    $customerId = $check->id;
                }
            }

            //Order master
            $orderKey = $request->order;
            $order = Order::find($request->order['id']);
            unset($orderKey['id']);
            foreach ($orderKey as $key => $item) {
                $order->$key = $item;
            }

            if ($request->customer['type'] != 'G') {
                $order->customer_id = $customerId;
            } else {
                $order->customer_id = NULL;
                $order->customer_name = $request->customer['name'];
                $order->customer_phone = $request->customer['phone'];
                $order->customer_address = $request->customer['address'];
            }
            $order->table_id = $request->tableCart[0]['table_id'];
            $order->status = 'a';
            $order->updated_by = Auth::user()->id;
            $order->updated_at = Carbon::now();
            $order->last_update_ip = request()->ip();
            $order->update();

            //old order detail
            $olddetail = OrderDetails::where('order_id', $request->order['id'])->get();
            foreach ($olddetail as $item) {
                // old detail delete
                OrderDetails::find($item->id)->forceDelete();
            }

            // Order detail
            foreach ($request->carts as $cart) {
                unset($cart['code']);
                unset($cart['name']);
                $detail = new OrderDetails();
                foreach ($cart as $key => $item) {
                    $detail->$key = $item;
                }
                $detail->order_id = $order->id;
                $detail->added_by = Auth::user()->id;
                $detail->last_update_ip = request()->ip();
                $detail->save();

                $recipes = Recipe::where('menu_id', $cart['menu_id'])->get();
                if (isset($recipes)) {
                    $production = Production::where('order_id', $order->id)->first();
                    $production->date = date('Y-m-d');
                    $production->total = $recipes->sum('total');
                    $production->updated_by = Auth::user()->id;
                    $production->updated_at = Carbon::now();
                    $production->last_update_ip = request()->ip();
                    $production->update();

                    //old production detail
                    $oldProductionDetail = ProductionDetail::where('production_id', $production->id)->get();
                    foreach ($oldProductionDetail as $opd) {
                        ProductionDetail::find($opd->id)->forceDelete();
                    }

                    foreach ($recipes as $item) {
                        $productionDetails = new ProductionDetail();
                        $productionDetails->production_id = $production->id;
                        $productionDetails->material_id = $item->material_id;
                        $productionDetails->quantity = $item->quantity;
                        $productionDetails->price = $item->price;
                        $productionDetails->total = $item->total;
                        $productionDetails->status = 'a';
                        $productionDetails->added_by = Auth::user()->id;
                        $productionDetails->last_update_ip = request()->ip();
                        $productionDetails->save();
                    }
                }
            }

            DB::commit();
            return response()->json(['status' => true, 'message' => 'Order update successfully.', 'id' => $order->id], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function storeDraft(OrderRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        if ($request->customer['type'] == 'G' && $request->order['paid'] < $request->order['total']) {
            return send_error("Cash Guest can not due", null, 422);
        }

        $checkInvoice = Order::where('invoice', $request->order['invoice'])->first();
        $invoice = $request->order['invoice'];
        if (!empty($checkInvoice)) {
            $invoice = invoiceGenerate("Order", 'O');
        }

        try {
            DB::beginTransaction();

            //customer
            if ($request->customer['type'] != 'G') {
                $check = Customer::where('phone', $request->customer['phone'])->first();
                if (empty($check)) {
                    $customer = new Customer();
                    $customer->code = generateCode("Customer", "C");
                    $customer->name = $request->customer['name'];
                    $customer->phone = $request->customer['phone'];
                    $customer->address = $request->customer['address'];
                    $customer->added_by = Auth::user()->id;
                    $customer->last_update_ip = request()->ip();
                    $customer->save();
                    $customerId = $customer->id;
                } else {
                    $customerId = $check->id;
                }
            }

            //Order master
            $orderKey = $request->order;
            $order = new Order();
            unset($orderKey['id']);
            unset($orderKey['invoice']);
            foreach ($orderKey as $key => $item) {
                $order->$key = $item;
            }
            $order->invoice = $invoice;
            if ($request->customer['type'] != 'G') {
                $order->customer_id = $customerId;
            } else {
                $order->customer_id = NULL;
                $order->customer_name = $request->customer['name'];
                $order->customer_phone = $request->customer['phone'];
                $order->customer_address = $request->customer['address'];
            }
            $order->table_id = $request->tableCart[0]['table_id'];
            $order->order_type = 'Order';
            $order->status = 'p';
            $order->added_by = Auth::user()->id;
            $order->last_update_ip = request()->ip();
            $order->save();

            // Order detail
            foreach ($request->carts as $cart) {
                unset($cart['code']);
                unset($cart['name']);
                $detail = new OrderDetails();
                foreach ($cart as $key => $item) {
                    $detail->$key = $item;
                }
                $detail->order_id = $order->id;
                $detail->added_by = Auth::user()->id;
                $detail->last_update_ip = request()->ip();
                $detail->save();

                $recipes = Recipe::where('menu_id', $cart['menu_id'])->get();
                if (isset($recipes)) {
                    $production = new Production();
                    $production->invoice = invoiceGenerate('Production', 'PR');
                    $production->date = date('Y-m-d');
                    $production->order_id = $order->id;
                    $production->total = $recipes->sum('total');
                    $production->description = 'Order production invoice -' . $invoice;
                    $production->status = 'a';
                    $production->added_by = Auth::user()->id;
                    $production->last_update_ip = request()->ip();
                    $production->save();

                    foreach ($recipes as $item) {
                        $productionDetails = new ProductionDetail();
                        $productionDetails->production_id = $production->id;
                        $productionDetails->material_id = $item->material_id;
                        $productionDetails->quantity = $item->quantity;
                        $productionDetails->price = $item->price;
                        $productionDetails->total = $item->total;
                        $productionDetails->status = 'a';
                        $productionDetails->added_by = Auth::user()->id;
                        $productionDetails->last_update_ip = request()->ip();
                        $productionDetails->save();
                    }
                }
            }

            // Order tables
            // foreach ($request->tableCart as $table) {
            //     $tables = new OrderTables();
            //     $tables->order_id = $order->id;
            //     $tables->table_id = $table['table_id'];
            //     $tables->incharge_id = $table['inchargeId'];
            //     $tables->date = date('Y-m-d');
            //     $tables->booking_status = 'booked';
            //     $tables->added_by = Auth::user()->id;
            //     $tables->last_update_ip = request()->ip();
            //     $tables->save();
            // }

            DB::commit();
            return response()->json(['status' => true, 'message' => 'Order insert successfully', 'id' => $order->id], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function updateDraft(OrderRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        if ($request->customer['type'] == 'G' && $request->order['paid'] < $request->order['total']) {
            return send_error("Cash Guest can not due", null, 422);
        }

        try {
            DB::beginTransaction();
            //customer
            if ($request->customer['type'] != 'G') {
                $check = Customer::where('phone', $request->customer['phone'])->first();
                if (empty($check)) {
                    $customer = new Customer();
                    $customer->code = generateCode("Customer", "C");
                    $customer->name = $request->customer['name'];
                    $customer->phone = $request->customer['phone'];
                    $customer->address = $request->customer['address'];
                    $customer->added_by = Auth::user()->id;
                    $customer->last_update_ip = request()->ip();
                    $customer->save();
                    $customerId = $customer->id;
                } else {
                    $customerId = $check->id;
                }
            }

            //Order master
            $orderKey = $request->order;
            $order = Order::find($request->order['id']);
            unset($orderKey['id']);
            foreach ($orderKey as $key => $item) {
                $order->$key = $item;
            }

            if ($request->customer['type'] != 'G') {
                $order->customer_id = $customerId;
            } else {
                $order->customer_id = NULL;
                $order->customer_name = $request->customer['name'];
                $order->customer_phone = $request->customer['phone'];
                $order->customer_address = $request->customer['address'];
            }
            $order->table_id = $request->tableCart[0]['table_id'];
            $order->status = 'p';
            $order->updated_by = Auth::user()->id;
            $order->updated_at = Carbon::now();
            $order->last_update_ip = request()->ip();
            $order->update();

            //old order detail
            $olddetail = OrderDetails::where('order_id', $request->order['id'])->get();
            foreach ($olddetail as $item) {
                // old detail delete
                OrderDetails::find($item->id)->forceDelete();
            }

            // Order detail
            foreach ($request->carts as $cart) {
                unset($cart['code']);
                unset($cart['name']);
                $detail = new OrderDetails();
                foreach ($cart as $key => $item) {
                    $detail->$key = $item;
                }
                $detail->order_id = $order->id;
                $detail->added_by = Auth::user()->id;
                $detail->last_update_ip = request()->ip();
                $detail->save();

                $recipes = Recipe::where('menu_id', $cart['menu_id'])->get();
                if (isset($recipes)) {
                    $production = Production::where('order_id', $order->id)->first();
                    $production->date = date('Y-m-d');
                    $production->total = $recipes->sum('total');
                    $production->updated_by = Auth::user()->id;
                    $production->updated_at = Carbon::now();
                    $production->last_update_ip = request()->ip();
                    $production->update();

                    //old production detail
                    $oldProductionDetail = ProductionDetail::where('production_id', $production->id)->get();
                    foreach ($oldProductionDetail as $opd) {
                        ProductionDetail::find($opd->id)->forceDelete();
                    }

                    foreach ($recipes as $item) {
                        $productionDetails = new ProductionDetail();
                        $productionDetails->production_id = $production->id;
                        $productionDetails->material_id = $item->material_id;
                        $productionDetails->quantity = $item->quantity;
                        $productionDetails->price = $item->price;
                        $productionDetails->total = $item->total;
                        $productionDetails->status = 'a';
                        $productionDetails->added_by = Auth::user()->id;
                        $productionDetails->last_update_ip = request()->ip();
                        $productionDetails->save();
                    }
                }
            }

            DB::commit();
            return response()->json(['status' => true, 'message' => 'Order update successfully.', 'id' => $order->id], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function getOrder(Request $request)
    {
        try {
            $whereCluase = [];
            if (!empty($request->id)) {
                array_push($whereCluase, ['id', '=', $request->id]);
            }
            if (!empty($request->invoice)) {
                array_push($whereCluase, ['invoice', 'LIKE', $request->invoice . '%']);
            }
            if (!empty($request->customerId)) {
                array_push($whereCluase, ['customer_id', '=', $request->customerId]);
            }
            if (!empty($request->bookingId)) {
                array_push($whereCluase, ['booking_id', '=', $request->bookingId]);
            }
            if (!empty($request->tableId)) {
                array_push($whereCluase, ['table_id', '=', $request->tableId]);
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
                $orders = Order::with('orderDetails', 'customer', 'table', 'bank', 'user')->where($whereCluase)->latest('id');
            } else {
                $orders = Order::with('customer', 'table', 'bank', 'user')->where($whereCluase)->latest('id');
            }

            if (!empty($request->forSearch)) {
                $orders = $orders->limit(20)->get();
            } else {
                $orders = $orders->get();
            }

            foreach ($orders as $key => $item) {
                if ($item->customer_id != null || $item->customer_id != '') {
                    $item->customer = DB::select("select * from customers where id = ?", [$item->customer_id])[0];
                } else {
                    $item->customer = null;
                }
            }
            return response()->json($orders);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function orderDetails(Request $request)
    {
        try {
            $whereCluase = "";
            if (!empty($request->customerId)) {
                $whereCluase .= " AND c.id = '$request->customerId'";
            }

            if (!empty($request->menuId)) {
                $whereCluase .= " AND m.id = '$request->menuId'";
            }

            if (!empty($request->categoryId)) {
                $whereCluase .= " AND mc.id = '$request->categoryId'";
            }

            if (!empty($request->status)) {
                $whereCluase .= " AND od.status = '$request->status'";
            }

            if (!empty($request->dateFrom) && !empty($request->dateTo)) {
                $whereCluase .= " AND o.date BETWEEN '$request->dateFrom' AND '$request->dateTo'";
            }
            $details = DB::select("SELECT
                            od.*,
                            m.code,
                            m.name,
                            m.menu_category_id,
                            mc.name as category_name,
                            o.invoice,
                            o.date,
                            ifnull(c.code, 'Cash Guest') as customer_code,
                            ifnull(c.name, o.customer_name) as customer_name
                        FROM order_details od
                        LEFT JOIN menus m ON m.id = od.menu_id
                        LEFT JOIN menu_categories mc ON mc.id = m.menu_category_id
                        LEFT JOIN orders o ON o.id = od.order_id
                        LEFT JOIN customers c ON c.id = o.customer_id
                        WHERE od.status != 'd' 
                        $whereCluase");

            return response()->json($details);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function tableBookingList(Request $request)
    {
        try {
            $whereCluase = "";
            if (!empty($request->dateFrom) && !empty($request->dateTo)) {
                $whereCluase .= " AND tb.date BETWEEN '$request->dateFrom' AND '$request->dateTo'";
            }
            
            $bookings = DB::select("SELECT tb.* FROM table_bookings tb WHERE tb.status != 'd' $whereCluase");

            return response()->json($bookings);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function orderDetailsByTable(Request $request)
    {
        try {
            $orders = DB::select("SELECT id FROM orders WHERE status = 'p' AND table_id = '$request->tableId' ORDER BY date DESC LIMIT 1");
            return response()->json($orders);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function orderInvoicePrint($id)
    {
        if (!checkAccess('orderInvoice')) {
            return view('error.unauthorize');
        }

        return view("administration.restaurant.orderInvoice", compact('id'));
    }

    public function destroy(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = Order::find($request->id);
            $data->status = 'd';
            $data->last_update_ip = request()->ip();
            $data->deleted_by = Auth::user()->id;
            $data->update();

            //old order detail
            $olddetail = OrderDetails::where('order_id', $request->id)->get();
            foreach ($olddetail as $item) {
                // old detail delete
                $detail = OrderDetails::find($item->id);
                $detail->status = 'd';
                $detail->last_update_ip = request()->ip();
                $detail->deleted_at = Carbon::now();
                $detail->deleted_by = Auth::user()->id;
                $detail->update();
            }

            $data->delete();
            DB::commit();
            return response()->json(['status' => true, 'message' => 'Order delete successfully.'], 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
            DB::rollBack();
        }
    }

    public function destroyBooking(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = TableBooking::find($request->id);
            $data->status = 'd';
            $data->last_update_ip = request()->ip();
            $data->deleted_by = Auth::user()->id;
            $data->update();

            $data->delete();
            DB::commit();
            return response()->json(['status' => true, 'message' => 'Table booking deleted successfully.'], 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
            DB::rollBack();
        }
    }

    public function approve(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = Order::find($request->id);
            $data->status = 'a';
            $data->paid = $data->due;
            $data->due = 0.00;
            $data->added_by = Auth::user()->id;
            $data->last_update_ip = request()->ip();
            $data->update();

            //old order detail
            $orderDetails = OrderDetails::where('order_id', $request->id)->get();
            foreach ($orderDetails as $item) {
                $detail = OrderDetails::find($item->id);
                $detail->status = 'a';
                $detail->added_by = Auth::user()->id;
                $detail->last_update_ip = request()->ip();
                $detail->update();
            }

            DB::commit();
            return response()->json(['status' => true, 'message' => 'Order approve successfully.'], 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
            DB::rollBack();
        }
    }

    public function approveBooking(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = TableBooking::find($request->id);
            $data->status = 'a';
            $data->updated_by = Auth::user()->id;
            $data->last_update_ip = request()->ip();
            $data->update();

            DB::commit();
            return response()->json(['status' => true, 'message' => 'Table booking approved successfully.'], 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
            DB::rollBack();
        }
    }

    public function cancelBooking(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = TableBooking::find($request->id);
            $data->status = 'c';
            $data->updated_by = Auth::user()->id;
            $data->last_update_ip = request()->ip();
            $data->update();

            DB::commit();
            return response()->json(['status' => true, 'message' => 'Table booking cancelled successfully.'], 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
            DB::rollBack();
        }
    }

    // Pay First Order Functions   
    public function payFirst($id = 0)
    {
        if (!checkAccess('payFirst')) {
            return view('error.unauthorize');
        }

        $check = Order::where('id', $id)->first();
        if (empty($check)) {
            if ($id != 0) {
                Session::flash('error', 'Order not found');
            }
            $id = 0;
        }
        $invoice = invoiceGenerate("Order", 'O');

        return view('administration.restaurant.payFirst', compact('id', 'invoice'));
    }
    public function storePayFirst(OrderRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        if ($request->customer['type'] == 'G' && $request->order['paid'] < $request->order['total']) {
            return send_error("Cash Guest can not due", null, 422);
        }

        $checkInvoice = Order::where('invoice', $request->order['invoice'])->first();
        $invoice = $request->order['invoice'];
        if (!empty($checkInvoice)) {
            $invoice = invoiceGenerate("Order", 'O');
        }

        try {
            DB::beginTransaction();
            //customer
            if ($request->customer['type'] != 'G') {
                $check = Customer::where('phone', $request->customer['phone'])->first();
                if (empty($check)) {
                    $customer = new Customer();
                    $customer->code = generateCode("Customer", "C");
                    $customer->name = $request->customer['name'];
                    $customer->phone = $request->customer['phone'];
                    $customer->address = $request->customer['address'];
                    $customer->added_by = Auth::user()->id;
                    $customer->last_update_ip = request()->ip();
                    $customer->save();
                    $customerId = $customer->id;
                } else {
                    $customerId = $check->id;
                }
            }

            //Order master
            $orderKey = $request->order;
            $order = new Order();
            unset($orderKey['id']);
            unset($orderKey['invoice']);
            foreach ($orderKey as $key => $item) {
                $order->$key = $item;
            }
            $order->invoice = $invoice;
            if ($request->customer['type'] != 'G') {
                $order->customer_id = $customerId;
            } else {
                $order->customer_id = NULL;
                $order->customer_name = $request->customer['name'];
                $order->customer_phone = $request->customer['phone'];
                $order->customer_address = $request->customer['address'];
            }
            $order->added_by = Auth::user()->id;
            $order->last_update_ip = request()->ip();
            $order->save();

            // Order detail
            foreach ($request->carts as $cart) {
                unset($cart['code']);
                unset($cart['name']);
                $detail = new OrderDetails();
                foreach ($cart as $key => $item) {
                    $detail->$key = $item;
                }
                $detail->order_id = $order->id;
                $detail->added_by = Auth::user()->id;
                $detail->last_update_ip = request()->ip();
                $detail->save();

                $recipes = Recipe::where('menu_id', $cart['menu_id'])->get();
                if (isset($recipes)) {
                    $production = new Production();
                    $production->invoice = invoiceGenerate('Production', 'PR');
                    $production->date = date('Y-m-d');
                    $production->order_id = $order->id;
                    $production->total = $recipes->sum('total');
                    $production->description = 'Order production invoice -' . $invoice;
                    $production->status = 'a';
                    $production->added_by = Auth::user()->id;
                    $production->last_update_ip = request()->ip();
                    $production->save();

                    foreach ($recipes as $item) {
                        $productionDetails = new ProductionDetail();
                        $productionDetails->production_id = $production->id;
                        $productionDetails->material_id = $item->material_id;
                        $productionDetails->quantity = $item->quantity;
                        $productionDetails->price = $item->price;
                        $productionDetails->total = $item->total;
                        $productionDetails->status = 'a';
                        $productionDetails->added_by = Auth::user()->id;
                        $productionDetails->last_update_ip = request()->ip();
                        $productionDetails->save();
                    }
                }
            }

            DB::commit();
            return response()->json(['status' => true, 'message' => 'Order insert successfully', 'id' => $order->id], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return send_error("Something went wrong", $th->getMessage());
        }
    }
    public function updatePayFirst(OrderRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        if ($request->customer['type'] == 'G' && $request->order['paid'] < $request->order['total']) {
            return send_error("Cash Guest can not due", null, 422);
        }

        try {
            DB::beginTransaction();
            //customer
            if ($request->customer['type'] != 'G') {
                $check = Customer::where('phone', $request->customer['phone'])->first();
                if (empty($check)) {
                    $customer = new Customer();
                    $customer->code = generateCode("Customer", "C");
                    $customer->name = $request->customer['name'];
                    $customer->phone = $request->customer['phone'];
                    $customer->address = $request->customer['address'];
                    $customer->added_by = Auth::user()->id;
                    $customer->last_update_ip = request()->ip();
                    $customer->save();
                    $customerId = $customer->id;
                } else {
                    $customerId = $check->id;
                }
            }

            //Order master
            $orderKey = $request->order;
            $order = Order::find($request->order['id']);
            unset($orderKey['id']);
            foreach ($orderKey as $key => $item) {
                $order->$key = $item;
            }

            if ($request->customer['type'] != 'G') {
                $order->customer_id = $customerId;
            } else {
                $order->customer_id = NULL;
                $order->customer_name = $request->customer['name'];
                $order->customer_phone = $request->customer['phone'];
                $order->customer_address = $request->customer['address'];
            }
            $order->updated_by = Auth::user()->id;
            $order->updated_at = Carbon::now();
            $order->last_update_ip = request()->ip();
            $order->update();

            //old order detail
            $olddetail = OrderDetails::where('order_id', $request->order['id'])->get();
            foreach ($olddetail as $item) {
                // old detail delete
                OrderDetails::find($item->id)->forceDelete();
            }

            // Order detail
            foreach ($request->carts as $cart) {
                unset($cart['code']);
                unset($cart['name']);
                $detail = new OrderDetails();
                foreach ($cart as $key => $item) {
                    $detail->$key = $item;
                }
                $detail->order_id = $order->id;
                $detail->added_by = Auth::user()->id;
                $detail->last_update_ip = request()->ip();
                $detail->save();

                $recipes = Recipe::where('menu_id', $cart['menu_id'])->get();
                if (isset($recipes)) {
                    $production = Production::where('order_id', $order->id)->first();
                    $production->date = date('Y-m-d');
                    $production->total = $recipes->sum('total');
                    $production->updated_by = Auth::user()->id;
                    $production->updated_at = Carbon::now();
                    $production->last_update_ip = request()->ip();
                    $production->update();

                    //old production detail
                    $oldProductionDetail = ProductionDetail::where('production_id', $production->id)->get();
                    foreach ($oldProductionDetail as $opd) {
                        ProductionDetail::find($opd->id)->forceDelete();
                    }

                    foreach ($recipes as $item) {
                        $productionDetails = new ProductionDetail();
                        $productionDetails->production_id = $production->id;
                        $productionDetails->material_id = $item->material_id;
                        $productionDetails->quantity = $item->quantity;
                        $productionDetails->price = $item->price;
                        $productionDetails->total = $item->total;
                        $productionDetails->status = 'a';
                        $productionDetails->added_by = Auth::user()->id;
                        $productionDetails->last_update_ip = request()->ip();
                        $productionDetails->save();
                    }
                }
            }

            DB::commit();
            return response()->json(['status' => true, 'message' => 'Order update successfully.', 'id' => $order->id], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return send_error("Something went wrong", $th->getMessage());
        }
    }
    public function destroyPayFirst(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = Order::find($request->id);
            $data->status = 'd';
            $data->last_update_ip = request()->ip();
            $data->deleted_by = Auth::user()->id;
            $data->update();

            //old order detail
            $olddetail = OrderDetails::where('order_id', $request->id)->get();
            foreach ($olddetail as $item) {
                // old detail delete
                $detail = OrderDetails::find($item->id);
                $detail->status = 'd';
                $detail->last_update_ip = request()->ip();
                $detail->deleted_at = Carbon::now();
                $detail->deleted_by = Auth::user()->id;
                $detail->update();
            }

            $data->delete();
            DB::commit();
            return response()->json(['status' => true, 'message' => 'Order delete successfully.'], 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
            DB::rollBack();
        }
    }
}
