<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Table extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function tabletype()
    {
        return $this->belongsTo(TableType::class, 'table_type_id', 'id')->select('id', 'name');
    }

    public function floor()
    {
        return $this->belongsTo(Floor::class, 'floor_id', 'id')->select('id', 'name');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'incharge_id', 'id')->select('id', 'name');
    }
}
