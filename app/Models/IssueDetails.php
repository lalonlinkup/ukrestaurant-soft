<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IssueDetails extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function issue() {
        return $this->belongsTo(Issue::class);
    }

    public function asset() {
        return $this->belongsTo(Asset::class, 'asset_id', 'id')->with('brand', 'unit');
    }

}
