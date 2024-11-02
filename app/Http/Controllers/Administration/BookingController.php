<?php

namespace App\Http\Controllers\Administration;

use Illuminate\Http\Request;
use App\Models\BookingMaster;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\BookingRequest;
use App\Models\BookingDetail;
use App\Models\Customer;
use App\Models\CustomerPayment;
use App\Models\OtherCustomer;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $detailClauses = "";
        if (!empty($request->bookingStatus) && $request->bookingStatus == 'booked') {
            $detailClauses .= " and bkd.booking_status = '$request->bookingStatus'";
        } else if (!empty($request->bookingStatus) && $request->bookingStatus == 'checkinRecord') {
            $detailClauses .= " and bkd.booking_status = '$request->bookingStatus'";
        }

        if (!empty($request->checkoutDate)) {
            $checkout_date = $request->checkoutDate . ' 11:59:00';
            $detailClauses .= " and bkd.checkout_date = '$checkout_date'";
        }

        $clauses = "";
        if (!empty($request->dateFrom) && !empty($request->dateTo)) {
            $clauses .= " and bkm.date between '$request->dateFrom' and '$request->dateTo'";
        }
        if (!empty($request->customerId)) {
            $clauses .= " and bkm.customer_id = '$request->customerId'";
        }
        if (!empty($request->userId)) {
            $clauses .= " and bkm.added_by = '$request->userId'";
        }
        if (!empty($request->invoice)) {
            $clauses .= " and bkm.invoice like '$request->invoice%'";
        }
        if (!empty($request->id)) {
            $clauses .= " and bkm.id = '$request->id'";
        }
        $bookings = DB::select("select bkm.*,
                                c.code as customer_code,
                                ifnull(c.name, '') as customer_name,
                                ifnull(c.phone, '') as customer_phone,
                                ifnull(c.nid, '') as customer_nid,
                                ifnull(c.address, '') as customer_address,
                                ifnull(r.code, '') as reference_code,
                                ifnull(r.name, '') as reference_name,
                                ifnull(u.username, '') as addBy
                                from booking_masters bkm
                                left join customers c on c.id = bkm.customer_id
                                left join `references` r on r.id = bkm.reference_id
                                left join users u on u.id = bkm.added_by
                                where bkm.status = 'a' $clauses 
                                order by bkm.id desc");

        // if ((!empty($request->recordType) && $request->recordType == 'with') || !empty($request->id)) {
        foreach ($bookings as $key => $booking) {
            $booking->booking_details = DB::select("select bkd.*,
                                                        rm.code as room_code,
                                                        rm.name as room_name,
                                                        tp.name as type_name,
                                                        c.name as category_name
                                                        from booking_details bkd
                                                        left join rooms rm on rm.id = bkd.room_id
                                                        left join room_types tp on tp.id = rm.room_type_id
                                                        left join categories c on c.id = rm.category_id
                                                        where bkd.status = 'a'
                                                        and bkd.booking_id = ?
                                                        $detailClauses", [$booking->id]);

            if (!empty($request->id)) {
                $booking->othercustomer = DB::select("select oc.*
                                                from other_customers oc
                                                where oc.booking_id = ?", [$booking->id]);
            }

            if (count($booking->booking_details) == 0) {
                unset($bookings[$key]);
            }
        }
        // }

        return response()->json(array_values($bookings));
    }

    public function bookingRecord()
    {
        if (!checkAccess('bookingRecord')) {
            return view('error.unauthorize');
        }

        return view("administration.booking.bookingRecord");
    }

    public function checkinRecord()
    {
        if (!checkAccess('checkinRecord')) {
            return view('error.unauthorize');
        }

        return view("administration.booking.checkinRecord");
    }

    public function billingRecord()
    {
        if (!checkAccess('billingRecord')) {
            return view('error.unauthorize');
        }

        return view("administration.booking.billingRecord");
    }

    public function create($id = 0)
    {
        if (!checkAccess('booking')) {
            return view('error.unauthorize');
        }

        return view("administration.booking.create", compact('id'));
    }

    public function store(BookingRequest $request)
    {
        // if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        try {
            DB::beginTransaction();

            $customerId = "";
            // new customer insert
            if (isset($request->customer)) {
                $customer = (object)$request->customer;
                $customerInfo = array(
                    "code"           => generateCode('Customer', 'C'),
                    "name"           => $customer->name,
                    "nid"            => $customer->nid,
                    "phone"          => $customer->phone,
                    "address"        => $customer->address,
                    "reference_id"   => $customer->reference_id,
                    "added_by"       => Auth::user()->id,
                    "last_update_ip" => request()->ip(),
                );
                $cus = Customer::create($customerInfo);

                $customerId = $cus->id;
            } else {
                $customerId = $request->booking['customer_id'];
            }

            $bookingKey = $request->booking;
            $booking = new BookingMaster();
            unset($bookingKey['id']);
            unset($bookingKey['invoice']);
            unset($bookingKey['customer_id']);
            unset($bookingKey['booking_status']);
            unset($bookingKey['is_other']);
            foreach ($bookingKey as $key => $item) {
                $booking->$key = $item;
            }
            $booking->customer_id    = $customerId;
            $booking->invoice        = invoiceGenerate('Booking_Master', '');
            $booking->is_other       = $request->booking['is_other'] == true ? 'true' : 'false';
            $booking->others_member  = $request->booking['is_other'] == true ? count($request->members) : 0;
            $booking->added_by       = Auth::user()->id;
            $booking->last_update_ip = request()->ip();
            $booking->save();

            if ($request->booking['is_other'] == true) {
                // multiple customer
                foreach ($request->members as $key => $other) {
                    $othercus = new OtherCustomer();
                    unset($other['room_name']);
                    foreach ($other as $key => $item) {
                        $othercus->$key = $item;
                    }
                    $othercus->booking_id = $booking->id;
                    $othercus->added_by = Auth::user()->id;
                    $othercus->last_update_ip = request()->ip();
                    $othercus->save();
                }
            }

            // booking details
            foreach ($request->carts as $key => $cart) {
                //details
                unset($cart['name']);
                unset($cart['typeName']);
                unset($cart['categoryName']);
                $detail = new BookingDetail();
                $detail->checkin_date   = $cart['checkin_date'] . ' 12:00:00';
                $detail->checkout_date  = $cart['checkout_date'] . ' 11:59:00';
                unset($cart['checkin_date']);
                unset($cart['checkout_date']);
                foreach ($cart as $key => $item) {
                    $detail->$key = $item;
                }
                $detail->booking_id     = $booking->id;
                $detail->booking_status = $request->booking['booking_status'];
                $detail->added_by       = Auth::user()->id;
                $detail->last_update_ip = request()->ip();
                $detail->save();
            }

            DB::commit();

            return response()->json([
                'id' => $booking->id,
                'message' => $request->booking['booking_status'] == 'booked' ? 'Booking insert successfully' : 'CheckIn insert successfully',
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function update(BookingRequest $request)
    {
        // if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        try {
            DB::beginTransaction();

            $customerId = "";
            // new customer insert
            if (isset($request->customer)) {
                $customer = (object)$request->customer;
                $customerInfo = array(
                    "code"           => generateCode('Customer', 'C'),
                    "name"           => $customer->name,
                    "nid"            => $customer->nid,
                    "phone"          => $customer->phone,
                    "address"        => $customer->address,
                    "reference_id"   => $customer->reference_id,
                    "added_by"       => Auth::user()->id,
                    "last_update_ip" => request()->ip(),
                );
                $cus = Customer::create($customerInfo);

                $customerId = $cus->id;
            } else {
                $customerId = $request->booking['customer_id'];
            }

            $bookingKey = $request->booking;
            $booking = BookingMaster::find($request->booking['id']);
            unset($bookingKey['id']);
            unset($bookingKey['invoice']);
            unset($bookingKey['customer_id']);
            unset($bookingKey['booking_status']);
            unset($bookingKey['is_other']);
            foreach ($bookingKey as $key => $item) {
                $booking->$key = $item;
            }
            $booking->customer_id    = $customerId;
            $booking->is_other       = $request->booking['is_other'] == true ? 'true' : 'false';
            $booking->others_member  = $request->booking['is_other'] == true ? count($request->members) : 0;
            $booking->updated_by     = Auth::user()->id;
            $booking->updated_at     = Carbon::now();
            $booking->last_update_ip = request()->ip();
            $booking->update();

            //other member delete
            OtherCustomer::where("booking_id", $request->booking['id'])->forceDelete();
            if ($request->booking['is_other'] == true) {
                // multiple customer
                foreach ($request->members as $key => $other) {
                    $othercus = new OtherCustomer();
                    unset($other['room_name']);
                    foreach ($other as $key => $item) {
                        $othercus->$key = $item;
                    }
                    $othercus->booking_id     = $booking->id;
                    $othercus->updated_by     = Auth::user()->id;
                    $othercus->added_by       = Auth::user()->id;
                    $othercus->updated_at     = Carbon::now();
                    $othercus->last_update_ip = request()->ip();
                    $othercus->save();
                }
            }

            // details deleted
            BookingDetail::where("booking_id", $request->booking['id'])->forceDelete();
            // booking details
            foreach ($request->carts as $key => $cart) {
                //details
                unset($cart['name']);
                unset($cart['typeName']);
                unset($cart['categoryName']);
                $detail = new BookingDetail();
                $detail->checkin_date   = $cart['checkin_date'] . ' 12:00:00';
                $detail->checkout_date  = $cart['checkout_date'] . ' 11:59:00';
                unset($cart['checkin_date']);
                unset($cart['checkout_date']);
                foreach ($cart as $key => $item) {
                    $detail->$key = $item;
                }
                $detail->booking_id     = $booking->id;
                $detail->booking_status = $request->booking['booking_status'];
                $detail->added_by       = Auth::user()->id;
                $detail->updated_by     = Auth::user()->id;
                $detail->updated_at     = Carbon::now();
                $detail->last_update_ip = request()->ip();
                $detail->save();
            }

            DB::commit();

            return response()->json([
                'id' => $booking->id,
                'message' => $request->booking['booking_status'] == 'booked' ? 'Booking updated successfully' : 'CheckIn update successfully',
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        BookingMaster::find($request->id)->update([
            'status' => 'd',
            'deleted_by' => Auth::user()->id,
            'deleted_at' => Carbon::now(),
            'last_update_ip' => request()->ip()
        ]);

        BookingDetail::where('booking_id', $request->id)->update([
            'status' => 'd',
            'deleted_by' => Auth::user()->id,
            'deleted_at' => Carbon::now(),
            'last_update_ip' => request()->ip()
        ]);

        OtherCustomer::where('booking_id', $request->id)->update([
            'deleted_by' => Auth::user()->id,
            'deleted_at' => Carbon::now(),
            'last_update_ip' => request()->ip()
        ]);

        return response()->json(['status' => false, 'message' => "Booking delete successfully"]);
    }

    public function bookingInvoice($id)
    {
        return view('administration.booking.bookingInvoice', compact('id'));
    }

    public function getroomList(Request $request)
    {
        $clauses = "";
        if (!empty($request->floorId)) {
            $clauses .= " and r.floor_id = '$request->floorId'";
        }
        if (!empty($request->typeId)) {
            $clauses .= " and r.room_type_id = '$request->typeId'";
        }

        if (!empty($request->categoryId)) {
            $clauses .= " and r.category_id = '$request->categoryId'";
        }

        $checkin_date = $request->checkin_date . ' 12:00:00';

        $floors = DB::select("select f.* from floors f where f.status = 'a'");

        foreach ($floors as $key => $floor) {
            $floor->rooms = DB::select("select r.*,
                                rt.name as roomtype_name
                                from rooms r
                                left join room_types rt on rt.id = r.room_type_id
                                where r.status != 'd' and r.deleted_at is null
                                and r.floor_id = ?
                                $clauses
                                ", [$floor->id]);

            foreach ($floor->rooms as  $item) {
                // $roomavailable = DB::select("select * from rooms rm where rm.id not in (select bkd.room_id from booking_details bkd where bkd.status = 'a' or bkd.checkout_status = 'true' and '$checkin_date' between bkd.checkin_date and bkd.checkout_date) and rm.id = ?", [$item->id]);
                // $item->available = count($roomavailable) > 0 ? 'true' : 'false';
                $roombooked = DB::select("select * from rooms rm where rm.id in (select bkd.room_id from booking_details bkd where bkd.status = 'a' and bkd.booking_status = 'booked' and '$checkin_date' between bkd.checkin_date and bkd.checkout_date) and rm.id = ?", [$item->id]);
                $item->booked = count($roombooked) > 0 ? 'true' : 'false';
                // $roomcheckin = DB::select("select * from rooms rm where rm.id in (select bkd.room_id from booking_details bkd where bkd.status = 'a' and bkd.booking_status = 'checkin' or bkd.checkout_status = 'false' and '$checkin_date' between bkd.checkin_date and bkd.checkout_date) and rm.id = ?", [$item->id]);
                // $item->checkin = count($roomcheckin) > 0 ? 'true' : 'false';

                $roomcheckin = DB::select("select * from booking_details bkd where bkd.checkout_status = 'false' and bkd.room_id = ?", [$item->id]);
                $item->checkin = 'false';
                if (count($roomcheckin) > 0) {
                    $checkin = DB::select("select * from booking_details bkd where '$checkin_date' between bkd.checkin_date and bkd.checkout_date and bkd.room_id = ?", [$item->id]);
                    $item->checkin = count($checkin) > 0 ? 'true' : 'false';
                }

                $item->available = 'false';
                if ($item->checkin == 'false' && $item->booked == 'false') {
                    $item->available = 'true';
                }

                if ($item->available == 'true') {
                    $item->color = "#aee2ff";
                } else if ($item->booked == 'true') {
                    $item->color = '#fffcb2';
                } else if ($item->checkin == 'true') {
                    $item->color = '#ff0000ab';
                } else {
                    $item->color = "#aee2ff";
                }
            }
        }

        return response()->json($floors, 200);
    }

    public function singleAvailableRoom(Request $request)
    {
        $clauses = "";
        if (!empty($request->booking_id)) {
            $clauses .= "and bkd.booking_id != '$request->booking_id'";
        }
        $totalDays = Carbon::parse($request->checkout_date)->diffInDays($request->checkin_date, 'days');
        for ($i = 0; $i < $totalDays; $i++) {
            $date = Carbon::parse($request->checkin_date)->addDays($i)->format('Y-m-d') . ' 12:00:00';
            $check = DB::select("select * from rooms rm where rm.id not in (select bkd.room_id from booking_details bkd where bkd.status = 'a' and bkd.booking_status != 'checkout' and bkd.checkout_status = 'true' $clauses and '$date' between bkd.checkin_date and bkd.checkout_date) and rm.id = ?", [$request->id]);

            if (count($check) == 0) {
                return response()->json(['status' => false, 'date' => date('d-m-Y', strtotime($date))]);
            }
        }

        return response()->json(['status' => true]);
    }

    public function roomBookingCalendar(Request $request)
    {
        $today = date('Y-m-d') . " 12:00:00";

        $query = DB::select("select bkd.*
        from booking_details bkd
        where bkd.room_id = ?
        and bkd.status = 'a' and bkd.booking_status != 'checkout'", [$request->roomId]);

        $events = [];
        $uniqueEvents = []; // Array to track unique events

        if (count($query) > 0) {
            foreach ($query as $key => $booking) {
                $booking_status = "";
                $booking_color = "";
                $color = "";
                if ($booking->booking_status == 'booked') {
                    $booking_status = "Booked";
                    $booking_color = '#fffcb2';
                    $color = '#000';
                } elseif ($booking->checkout_status == 'false' && $booking->booking_status == 'checkin') {
                    $booking_status = "CheckIn";
                    $booking_color = '#ff0000ab';
                    $color = '#fff';
                }

                for ($i = 0; $i < $booking->days; $i++) {
                    $eventStart = Carbon::parse($booking->checkin_date)->addDays($i)->format('Y-m-d 12:00:00');

                    if ($booking->checkout_status == 'false') {
                        if ($eventStart >= $today) {
                            $event = [
                                "start" => Carbon::parse($booking->checkin_date)->addDays($i),
                                "allDay" => true,
                                "rendering" => 'background',
                                "backgroundColor" => $booking_color,
                                "title" => $booking_status,
                                "textColor" => $color
                            ];
                        } else {
                            $event = [
                                "start" => Carbon::parse($today)->addDays($i),
                                "allDay" => true,
                                "rendering" => 'background',
                                "backgroundColor" => $booking_color,
                                "title" => $booking_status,
                                "textColor" => $color
                            ];
                        }

                        $uniqueKey = $event['start']->format('Y-m-d') . '_' . $booking->checkout_status;

                        if (!in_array($uniqueKey, $uniqueEvents)) {
                            $uniqueEvents[] = $uniqueKey;
                            array_push($events, $event);
                        }
                    }
                }
            }
        } else {
            array_push($events, [
                "start" => '',
                "allDay" => true,
                "rendering" => 'background',
                "backgroundColor" => '',
                "title" => '',
                "textColor" => ''
            ]);
        }

        return response()->json($events);
    }


    public function checkIn()
    {
        if (!checkAccess('checkIn')) {
            return view('error.unauthorize');
        }

        return view("administration.booking.checkin");
    }

    // save checkin
    public function saveCheckin(Request $request)
    {
        try {
            foreach ($request->detail as $key => $item) {
                BookingDetail::find($item['id'])->update([
                    'booking_status' => 'checkin',
                    'updated_at'     => Carbon::now(),
                    'updated_by'     => Auth::user()->id,
                    'last_update_ip' => request()->ip(),
                ]);
            }

            return response()->json('Checkin successfully', 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function checkOut()
    {
        if (!checkAccess('checkOut')) {
            return view('error.unauthorize');
        }

        return view("administration.booking.checkout");
    }

    // save checkout
    public function saveCheckOut(Request $request)
    {
        try {
            foreach ($request->detail as $key => $item) {
                $daysNum = Carbon::parse($request->checkout_date)->diffInDays($item['checkin_date'], 'days');
                BookingDetail::find($item['id'])->update([
                    'days'            => $daysNum + 1,
                    'total'           => ($daysNum + 1) * $item['unit_price'],
                    'checkout_status' => 'true',
                    'booking_status'  => 'checkout',
                    'checkout_date'   => Carbon::parse($request->checkout_date)->addDays(1)->format('Y-m-d 11:59:00'),
                    'updated_at'      => Carbon::now(),
                    'updated_by'      => Auth::user()->id,
                    'last_update_ip'  => request()->ip(),
                ]);
            }

            if (isset($request->payment)) {
                $payment = new CustomerPayment();
                $payment->invoice = generateCode("Customer_Payment", 'TR');
                $payment->date = date('Y-m-d');
                $payment->customer_id = $request->payment['customer_id'];
                $payment->booking_id = $request->payment['booking_id'];
                $payment->type = 'CR';
                $payment->method = 'cash';
                $payment->discount = $request->payment['discount'];
                $payment->discountAmount = $request->payment['discountAmount'];
                $payment->amount = $request->payment['amount'];
                $payment->status = 'a';
                $payment->added_by = Auth::user()->id;
                $payment->last_update_ip = request()->ip();
                $payment->save();
            }

            return response()->json('Checkout successfully', 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function checkinList()
    {
        return view('administration.booking.checkinList');
    }

    public function getCheckinList(Request $request)
    {
        $clauses = "";
        if (!empty($request->floorId)) {
            $clauses .= " and r.floor_id = '$request->floorId'";
        }
        if (!empty($request->typeId)) {
            $clauses .= " and r.room_type_id = '$request->typeId'";
        }

        if (!empty($request->categoryId)) {
            $clauses .= " and r.category_id = '$request->categoryId'";
        }

        if (!empty($request->roomId)) {
            $clauses .= " and r.id = '$request->roomId'";
        }

        $checkin_date = date('Y-m-d') . ' 12:00:00';

        $rooms = DB::select("select r.*,
                                rt.name as roomtype_name
                                from rooms r
                                left join room_types rt on rt.id = r.room_type_id
                                where r.status != 'd' and r.deleted_at is null
                                $clauses
                                ");

        foreach ($rooms as $key => $item) {
            $roomavailable = DB::select("select * from rooms rm where rm.id not in (select bkd.room_id from booking_details bkd where bkd.status = 'a' and '$checkin_date' between bkd.checkin_date and bkd.checkout_date) and rm.id = ?", [$item->id]);
            $item->available = count($roomavailable) > 0 ? 'true' : 'false';
            $roombooked = DB::select("select * from rooms rm where rm.id in (select bkd.room_id from booking_details bkd where bkd.status = 'a' and bkd.booking_status = 'booked' and '$checkin_date' between bkd.checkin_date and bkd.checkout_date) and rm.id = ?", [$item->id]);
            $item->booked = count($roombooked) > 0 ? 'true' : 'false';
            $roomcheckin = DB::select("select * from rooms rm where rm.id in (select bkd.room_id from booking_details bkd where bkd.status = 'a' and bkd.booking_status = 'checkin' and '$checkin_date' between bkd.checkin_date and bkd.checkout_date) and rm.id = ?", [$item->id]);
            $item->checkin = count($roomcheckin) > 0 ? 'true' : 'false';

            if ($item->available == 'true') {
                $item->color = "#aee2ff";
            } else if ($item->booked == 'true') {
                $item->color = '#fffcb2';
            } else if ($item->checkin == 'true') {
                $item->color = '#ff0000ab';
                $item->details = DB::select("select * from booking_details bkd where bkd.status = 'a' and '$checkin_date' between bkd.checkin_date and bkd.checkout_date and bkd.room_id = ? and bkd.booking_status = 'checkin'", [$item->id]);
                $item->customers = DB::select("select 
                                    c.id as customer_id,
                                    ifnull(c.name, '') as customer_name,
                                    ifnull(c.code, '') as customer_code,
                                    ifnull(c.phone, '') as customer_phone,
                                    ifnull(c.address, '') as customer_address,
                                    ifnull(d.name, '') as area_name
                                    from booking_masters bkm 
                                    left join customers c on c.id = bkm.customer_id
                                    left join districts d on d.id = c.district_id
                                    where bkm.id = ?", [$item->details[0]->booking_id])[0];
            }
        }

        $rooms = array_filter($rooms, function ($item) {
            return $item->checkin == 'true';
        });

        return response()->json(array_values($rooms), 200);
    }

    // billing invoice
    public function billingInvoice()
    {
        return view('administration.booking.billingInvoiceList');
    }

    public function billingInvoicePrint($id)
    {
        return view('administration.booking.billingInvoice', compact('id'));
    }
}
