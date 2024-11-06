<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function purchaseDetails() {
        return $this->hasMany(PurchaseDetails::class)->with('asset');
    }

    public function supplier() {
        return $this->belongsTo(Supplier::class)->select('id', 'code', 'name', 'phone', 'address', 'district_id');
    }

    public function employee() {
        return $this->belongsTo(Employee::class)->select('id', 'name', 'code');
    }

    public function user() {
        return $this->belongsTo(User::class, 'added_by', 'id')->select('id', 'name', 'phone');
    }
}
