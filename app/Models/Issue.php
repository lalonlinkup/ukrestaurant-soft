<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Issue extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function issueDetails() {
        return $this->hasMany(IssueDetails::class)->with('asset');
    }

    public function room() {
        return $this->belongsTo(Room::class)->select('id', 'name', 'code', 'price');
    }

    public function user() {
        return $this->belongsTo(User::class, 'added_by', 'id')->select('id', 'name', 'phone');
    }
}
