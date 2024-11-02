<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'date',
        'type',
        'bank_account_id',
        'amount'
    ];

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class)->select('id', 'name', 'number', 'bank_name', 'branch_name');
    }

    public function addBy() 
    {
        return $this->belongsTo(User::class, 'added_by', 'id')->select('id', 'name');
    }
}
