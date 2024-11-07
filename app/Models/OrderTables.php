<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderTables extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'order_tables';

    protected $fillable = [
        'order_id',
        'table_id',
        'date',
        'booking_status',
        'status'
    ];

    // public function order()
    // {
    //     return $this->belongsTo(Order::class);
    // }

    public function table()
    {
        return $this->belongsTo(Table::class, 'table_id', 'id')->with('tabletype', 'floor', 'employee');
    }
}
