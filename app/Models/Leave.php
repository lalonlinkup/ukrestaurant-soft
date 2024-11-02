<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Leave extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function employee() {
        return $this->belongsTo(Employee::class)->select('id', 'code', 'name', 'email', 'phone', 'designation_id', 'department_id')->with('designation', 'department');
    }

    public function leaveType() {
        return $this->belongsTo(LeaveType::class)->select('id', 'name');
    }
}
