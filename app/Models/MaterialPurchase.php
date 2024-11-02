<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialPurchase extends Model
{
    use HasFactory, SoftDeletes;

    protected $gurded = ['id'];

    protected $table = 'material_purchases';

    public function materialPurchaseDetails() {
        return $this->hasMany(MaterialPurchaseDetails::class)->with('material');
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
