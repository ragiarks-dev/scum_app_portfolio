<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProvisionalUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'login_id',
        'password',
        'key',
        'status',
    ];
}
