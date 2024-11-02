<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerPayment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'date',
        'invoice',
        'customer_id',
        'type',
        'method',
        'amount'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class)->select('id', 'code', 'name', 'phone');
    }

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class)->select('id', 'name', 'number', 'bank_name');
    }

    public function addBy() 
    {
        return $this->belongsTo(User::class, 'added_by', 'id')->select('id', 'name');
    }
}
