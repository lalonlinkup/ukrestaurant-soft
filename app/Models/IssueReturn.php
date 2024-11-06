<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IssueReturn extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function issueReturnDetails()
    {
        return $this->hasMany(IssueReturnDetails::class)->with('asset');
    }

    public function table() {
        return $this->belongsTo(Table::class)->select('id', 'name', 'code', 'price');
    }

    public function user() {
        return $this->belongsTo(User::class, 'added_by', 'id')->select('id', 'name', 'phone');
    }
}
