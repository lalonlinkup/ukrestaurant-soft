<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Disposal extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function room() {
        return $this->belongsTo(Room::class)->select('id', 'code', 'name');
    }

    public function disposalDetails() {
        return $this->hasMany(DisposalDetails::class)->with('asset');
    }

    public function user() {
        return $this->belongsTo(User::class, 'added_by', 'id')->select('id', 'name', 'phone');
    }
}
