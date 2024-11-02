<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function designation()
    {
        return $this->belongsTo(Designation::class)->select('id', 'name');
    }

    public function department()
    {
        return $this->belongsTo(Department::class)->select('id', 'name');
    }
}
