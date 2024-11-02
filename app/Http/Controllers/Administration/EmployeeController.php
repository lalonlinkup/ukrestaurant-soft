<?php

namespace App\Http\Controllers\Administration;

use Carbon\Carbon;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\EmployeePayment;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\EmployeePaymentDetail;
use App\Http\Requests\EmployeeRequest;
use App\Http\Requests\EmployeePaymentRequest;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $employees = Employee::with('designation', 'department');

        if (isset($request->designationId) && $request->designationId != '') {
            $employees = $employees->where('designation_id', $request->designationId);
        }

        if (isset($request->departmentId) && $request->departmentId != '') {
            $employees = $employees->where('department_id', $request->departmentId);
        }

        if (isset($request->empId) && $request->empId != '') {
            $employees = $employees->where('id', $request->empId);
        }

        $employees = $employees->latest()->get();

        return response()->json($employees);
    }

    public function create($id = 0)
    {
        if (!checkAccess('employee')) {
            return view('error.unauthorize');
        }

        if ($id != 0) {
            $code = Employee::where('id', $id)->first()->code;
        } else {
            $code = generateCode("Employee", 'E');
        }
        return view('administration.hrpayroll.employee.index', compact('code', 'id'));
    }

    public function list()
    {
        if (!checkAccess('employeeList')) {
            return view('error.unauthorize');
        }

        return view('administration.hrpayroll.employee.list');
    }

    public function store(EmployeeRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        $empunique = Employee::where('phone', $request->phone)->first();
        if (!empty($empunique)) return send_error("This employee already taken", null, 422);

        try {
            $check = DB::table('employees')->where('deleted_at', '!=', NULL)->where('name', $request->name)->first();;
            if (!empty($check)) {
                DB::select("UPDATE employees SET deleted_by = NULL, deleted_at = NULL , status = 'a' WHERE id = ?", [$check->id]);
            } else {
                $employee = new Employee();
                $employee->code = generateCode('Employee', 'E');
                $employeeKeys = $request->except('image', 'id', 'code');
                foreach (array_keys($employeeKeys) as $key) {
                    $employee->$key = $request->$key;
                }
                if ($request->hasFile('image')) {
                    $employee->image = imageUpload($request, 'image', 'uploads/employee', trim($request->code));
                }
                $employee->added_by = Auth::user()->id;
                $employee->last_update_ip = request()->ip();
                $employee->save();
            }

            return response()->json(['message' => "Employeee insert successfully", 'code' => generateCode("Employee", 'E')]);
        } catch (\Exception $ex) {
            return send_error("Something went wrong", $ex->getMessage(), $ex->getCode());
        }
    }

    public function update(EmployeeRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        $empunique = Employee::where('id', '!=', $request->id)->where('phone', $request->phone)->first();
        if (!empty($empunique)) return send_error("This employee already taken", null, 422);

        try {
            $employee = Employee::find($request->id);
            $employeeKeys = $request->except('image', 'id');
            foreach (array_keys($employeeKeys) as $key) {
                $employee->$key = $request->$key;
            }
            if ($request->hasFile('image')) {
                if (File::exists($employee->image)) {
                    File::delete($employee->image);
                }
                $employee->image = imageUpload($request, 'image', 'uploads/employee', trim($request->code));
            }
            $employee->updated_by = Auth::user()->id;
            $employee->updated_at = Carbon::now();
            $employee->last_update_ip = request()->ip();
            $employee->update();

            return response()->json(['message' => "Employeee update successfully", 'code' => generateCode("Employee", 'E')]);
        } catch (\Exception $ex) {
            return send_error("Something went wrong", $ex->getMessage(), $ex->getCode());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $data = Employee::find($request->id);
            if (File::exists($data->image)) {
                File::delete($data->image);
                $data->image = null;
            }
            $data->status = 'd';
            $data->last_update_ip = request()->ip();
            $data->deleted_by = Auth::user()->id;
            $data->update();

            $data->delete();
            return response()->json("Employee delete successfully");
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function salary()
    {
        if (!checkAccess('salaryPayment')) {
            return view('error.unauthorize');
        }

        return view('administration.hrpayroll.employee.salary');
    }

    public function checkPaymentMonth(Request $request)
    {
        $month = $request->month;
        $checkPayment = EmployeePayment::where('month', $month)->first();
        if ($checkPayment) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function getPayment(Request $request)
    {
        $payments = EmployeePayment::with('addBy')->where('status', 'a');

        if (!empty($request->paymentId) && $request->paymentId != '') {
            $payments = $payments->where('id', $request->paymentId);
        }

        if (!empty($request->month) && $request->month != '') {
            $payments = $payments->where('month', $request->month);
        }

        if (!empty($request->userId)) {
            $payments = $payments->where('added_by', $request->userId);
        }

        if (!empty($request->monthFrom) && !empty($request->monthTo)) {
            $payments = $payments->whereBetween('month', [$request->monthFrom, $request->monthTo]);
        }

        if (!empty($request->dateFrom) && !empty($request->dateTo)) {
            $payments = $payments->whereBetween('date', [$request->dateFrom, $request->dateTo]);
        }

        $payments = $payments->get();

        if (!empty($request->details)) {
            foreach ($payments as $payment) {
                $payment->details = EmployeePaymentDetail::with('employee', 'employee.department', 'employee.designation')->where('employee_payment_id', $payment->id)->get();
            }
        }

        return response()->json($payments);
    }

    public function addPayment(EmployeePaymentRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        try {
            DB::beginTransaction();
            $payment = new EmployeePayment();
            $payment->code = generateCode("Employee_payment", 'SI');
            $payment->date = $request->payment['date'];
            $payment->month = $request->payment['month'];
            $payment->total_employee = count($request->employees);
            $payment->added_by = Auth::user()->id;
            $payment->last_update_ip = request()->ip();
            $payment->save();

            $amount = 0;
            foreach ($request->employees as $detail) {
                $paymentDetail = new EmployeePaymentDetail();
                $paymentDetail->employee_payment_id = $payment->id;
                $paymentDetail->employee_id  = $detail['id'];
                $paymentDetail->salary  = $detail['salary'];
                $paymentDetail->benefit  = $detail['benefit'];
                $paymentDetail->deduction  = $detail['deduction'];
                $paymentDetail->net_payable  = $detail['net_payable'];
                $paymentDetail->payment  = $detail['payment'];
                $paymentDetail->comment  = $detail['comment'];
                $paymentDetail->added_by = Auth::user()->id;
                $paymentDetail->last_update_ip = request()->ip();
                $paymentDetail->save();

                $amount += $detail['payment'];
            }

            EmployeePayment::where('id', $payment->id)->update(['amount' => $amount]);
            DB::commit();
            return response()->json("Employeee Salary Payment successfully");
        } catch (\Exception $ex) {
            DB::rollback();
            return send_error("Something went wrong", $ex->getMessage(), $ex->getCode());
        }
    }

    public function updatePayment(EmployeePaymentRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        try {
            DB::beginTransaction();
            $payment = EmployeePayment::find($request->payment['id']);
            $payment->date = $request->payment['date'];
            $payment->month = $request->payment['month'];
            $payment->total_employee = count($request->employees);
            $payment->added_by = Auth::user()->id;
            $payment->last_update_ip = request()->ip();
            $payment->update();

            $amount = 0;
            foreach ($request->employees as $detail) {
                $paymentDetail = EmployeePaymentDetail::find($detail['id']);
                $paymentDetail->employee_payment_id = $payment->id;
                $paymentDetail->employee_id  = $detail['employee_id'];
                $paymentDetail->salary  = $detail['salary'];
                $paymentDetail->benefit  = $detail['benefit'];
                $paymentDetail->deduction  = $detail['deduction'];
                $paymentDetail->net_payable  = $detail['net_payable'];
                $paymentDetail->payment  = $detail['payment'];
                $paymentDetail->comment  = $detail['comment'];
                $paymentDetail->added_by = Auth::user()->id;
                $paymentDetail->last_update_ip = request()->ip();
                $paymentDetail->update();

                $amount += $detail['payment'];
            }

            EmployeePayment::where('id', $payment->id)->update(['amount' => $amount]);
            DB::commit();
            return response()->json("Employeee Salary Payment Updated");
        } catch (\Exception $ex) {
            DB::rollback();
            return send_error("Something went wrong", $ex->getMessage(), $ex->getCode());
        }
    }

    public function salaryRecord()
    {
        if (!checkAccess('salaryPaymentReport')) {
            return view('error.unauthorize');
        }

        return view('administration.hrpayroll.employee.salaryRecord');
    }

    public function getSalaryDetails(Request $request)
    {
        $details = EmployeePaymentDetail::with('employeePayment', 'employee', 'employee.department', 'employee.designation')->where('status', 'a');

        if (isset($month) && $month != '') {
            $details = $details->whereHas('employeePayment', function ($q) use ($request) {
                $q->where('month', $request->month);
            });
        }

        if (isset($request->employeeId) && $request->employeeId != '') {
            $details = $details->where('employee_id', $request->employeeId);
        }

        if (isset($request->userId) && $request->userId != '') {
            $details = $details->where('added_by', $request->userId);
        }

        if (!empty($request->dateFrom) && !empty($request->dateTo)) {
            $details = $details->whereBetween('date', [$request->dateFrom, $request->dateTo]);
        }

        $details = $details->get();

        return response()->json($details);
    }

    public function destroySalaryPayment(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = EmployeePayment::find($request->paymentId);
            $data->status = 'd';
            $data->deleted_by = Auth::user()->id;
            $data->update();
            $data->delete();

            $details = EmployeePaymentDetail::where('employee_payment_id', $request->paymentId)->get();

            if (count($details) > 0) {
                foreach ($details as $item) {
                    $item->status = 'd';
                    $item->deleted_by = Auth::user()->id;
                    $item->update();
                    $item->delete();
                }
            }

            DB::commit();
            return response()->json("Salary payment delete successfully");
        } catch (\Throwable $th) {
            DB::rollBack();
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function salaryInvoicePrint($id)
    {
        return view("administration.hrpayroll.employee.salaryInvoice", compact('id'));
    }
}
