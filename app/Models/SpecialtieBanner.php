<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialtieBanner extends Model
{
    use HasFactory;

    protected $fillable = ['image','updated_by'];
}
