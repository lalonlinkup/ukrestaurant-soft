<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeePayment extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function employeePaymentDetails()
    {
        return $this->hasMany(EmployeePaymentDetail::class);
    }

    public function addBy() 
    {
        return $this->belongsTo(User::class, 'added_by', 'id')->select('id', 'name');
    }
}
