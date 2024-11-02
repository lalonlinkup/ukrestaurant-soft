<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CashTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'date',
        'type',
        'account_id',
        'in_amount',
        'out_amount',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class)->select('id', 'code', 'name');
    }

    public function addBy() 
    {
        return $this->belongsTo(User::class, 'added_by', 'id')->select('id', 'name');
    }
}
