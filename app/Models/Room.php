<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function roomtype()
    {
        return $this->belongsTo(RoomType::class, 'room_type_id', 'id')->select('id', 'name');
    }

    public function floor()
    {
        return $this->belongsTo(Floor::class, 'floor_id', 'id')->select('id', 'name');
    }
}
