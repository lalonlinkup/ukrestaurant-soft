<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeePaymentDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function employeePayment()
    {
        return $this->belongsTo(EmployeePayment::class)->select('id', 'date', 'month', 'amount');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class)->select('id', 'code', 'name', 'designation_id', 'department_id');
    }
}
