<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialPurchaseDetails extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    
    public function materialPurchase() {
        return $this->belongsTo(MaterialPurchase::class);
    }

    public function material() {
        return $this->belongsTo(Material::class, 'material_id', 'id')->with('unit');
    }
}
