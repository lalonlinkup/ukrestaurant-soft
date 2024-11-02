<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'invoice',
        'customer_id',
        'date',
        'total',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id')->select('id', 'code', 'name', 'phone', 'address', 'nid', 'image');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id')->select('id', 'name', 'code');
    }

    public function bank()
    {
        return $this->belongsTo(BankAccount::class, 'bank_account_id', 'id')->select('id', 'name', 'number', 'bank_name', 'branch_name');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'added_by', 'id')->select('id', 'name', 'phone');
    }

    public function orderDetails() 
    {
        return $this->hasMany(OrderDetails::class, 'order_id', 'id')->with('menu');
    }
}
