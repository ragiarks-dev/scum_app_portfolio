<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KillLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'killer_name',
        'victim_name',
        'killer_steam_id',
        'victim_steam_id',
        'killer_latitude',
        'killer_longitude',
        'victim_latitude',
        'victim_longitude',
        'weapon',
        'kill_time',
        'status',
    ];
}
