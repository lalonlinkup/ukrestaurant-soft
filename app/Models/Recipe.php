<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recipe extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function menu() {
        return $this->belongsTo(Menu::class);
    }

    public function material() {
        return $this->belongsTo(Material::class);
    }
}
