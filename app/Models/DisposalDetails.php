<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DisposalDetails extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function disposal() {
        return $this->belongsTo(Disposal::class);
    }

    public function asset() {
        return $this->belongsTo(Asset::class)->select('id', 'code', 'name', 'price', 'brand_id')->with('brand');
    }

    public function user() {
        return $this->belongsTo(User::class, 'added_by', 'id')->select('id', 'name', 'phone');
    }
}
