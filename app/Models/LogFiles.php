<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogFiles extends Model
{
    use HasFactory;

    protected $fillable = [
      'file_name',
      'file_type',
      'file_date',
      'last_row',
      'status',
    ];
}
