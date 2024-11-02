<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductionDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function production() {
        return $this->belongsTo(Production::class);
    }

    public function material() {
        return $this->belongsTo(Material::class);
    }
}
