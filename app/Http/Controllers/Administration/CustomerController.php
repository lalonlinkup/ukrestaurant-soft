<?php

namespace App\Http\Controllers\Administration;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Requests\CustomerRequest;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $whereCluase = [];
        if (!empty($request->districtId)) {
            array_push($whereCluase, ['district_id', '=', $request->districtId]);
        }
        if (!empty($request->forSearch)) {
            $customers = Customer::with('district', 'reference')->where($whereCluase)->limit(20)->latest()->get();
        } elseif (!empty($request->name)) {
            $customers = Customer::with('district', 'reference')->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->name . '%')
                    ->orWhere('code', 'like', '%' . $request->name . '%')
                    ->orWhere('phone', 'like', '%' . $request->name . '%');
            })->get();
        } else {
            $customers = Customer::with('district', 'reference')->where($whereCluase)->latest()->get();
        }

        return response()->json($customers);
    }

    public function create()
    {
        if (!checkAccess('customer')) {
            return view('error.unauthorize');
        }

        return view('administration.settings.customer.index');
    }

    public function store(CustomerRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        $supunique = Customer::where('phone', $request->phone)->first();
        if (!empty($supunique)) return send_error("This phone number have been already exist..!", null, 422);
        try {
            $check = DB::table('customers')->where('deleted_at', '!=', NULL)->where('phone', $request->phone)->first();;
            if (!empty($check)) {
                DB::select("UPDATE customers SET deleted_by = NULL, deleted_at = NULL , status = 'a' WHERE id = ?", [$check->id]);
            } else {
                $customer_code = DB::select("select code from customers where code = ?", [$request->code]);
                if (count($customer_code) > 0) {
                    $code = generateCode('Customer', 'C');
                } else {
                    $code = $request->code;
                }
                $data         = new Customer();
                $data->code   = $code;
                $customerKeys = $request->except('image', 'id', 'code');
                foreach (array_keys($customerKeys) as $key) {
                    $data->$key = $request->$key;
                }
                if ($request->hasFile('image')) {
                    $data->image = imageUpload($request, 'image', 'uploads/customer', trim($request->code));
                }
                $data->added_by = Auth::user()->id;
                $data->last_update_ip = request()->ip();
                $data->save();
            }
            return response()->json("Customer insert successfully");
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }
    public function update(CustomerRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        $supunique = Customer::where('id', '!=', $request->id)->where('phone', $request->phone)->first();
        if (!empty($supunique)) return send_error("This phone number have been already exist..!", null, 422);
        try {
            $customer_code = DB::select("select code from customers where code = ? and id != ?", [$request->code, $request->id]);
            if (count($customer_code) > 0) return send_error("This supplier code already exists", null, 422);

            $data         = Customer::find($request->id);
            $customerKeys = $request->except('image', 'id');
            foreach (array_keys($customerKeys) as $key) {
                $data->$key = $request->$key;
            }
            if ($request->hasFile('image')) {
                if (File::exists($data->image)) {
                    File::delete($data->image);
                }
                $data->image = imageUpload($request, 'image', 'uploads/customer', trim($request->code));
            }
            $data->updated_by = Auth::user()->id;
            $data->updated_at = Carbon::now();
            $data->last_update_ip = request()->ip();
            $data->update();

            return response()->json("Customer update successfully");
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $data = Customer::find($request->id);
            if (File::exists($data->image)) {
                File::delete($data->image);
                $data->image = null;
            }
            $data->status = 'd';
            $data->last_update_ip = request()->ip();
            $data->deleted_by = Auth::user()->id;
            $data->update();

            $data->delete();
            return response()->json("Customer delete successfully");
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }


    public function customerList()
    {
        return view('administration.settings.customer.customerList');
    }
}
