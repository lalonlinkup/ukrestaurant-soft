<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserActivity extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'page_name',
        'ip_address',
        'login_time',
        'logout_time'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->select('id', 'name', 'username', 'email', 'phone', 'role');
    }
}
