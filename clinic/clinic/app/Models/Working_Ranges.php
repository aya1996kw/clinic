<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Working_Ranges extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'start_hour',
        'end_hour',

    ];
}
