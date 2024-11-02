<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function room() {
        return $this->belongsTo(Room::class)->select('id', 'code', 'name');
    }

    public function serviceHead() {
        return $this->belongsTo(ServiceHead::class)->select('id', 'code', 'name');
    }
}
