<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Production extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function productionDetails() {
        return $this->hasMany(ProductionDetail::class)->with('material');
    }

    public function order() {
        return $this->belongsTo(Order::class)->select('id', 'date', 'invoice', 'customer_id', 'customer_name', 'room_id')->with('customer');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'added_by', 'id')->select('id', 'name', 'phone');
    }
}
