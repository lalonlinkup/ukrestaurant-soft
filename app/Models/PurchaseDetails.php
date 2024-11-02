<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseDetails extends Model
{
    use HasFactory, SoftDeletes;

    protected $gurded = ['id'];
    
    public function purchase() {
        return $this->belongsTo(Purchase::class);
    }

    public function asset() {
        return $this->belongsTo(Asset::class, 'asset_id', 'id')->with('brand', 'unit');
    }
}
