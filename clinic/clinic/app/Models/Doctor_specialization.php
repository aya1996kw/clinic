<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor_specialization extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'specialization_id',
    ];
    public function Doctor()
    {
        return $this->belongsTo(User::class);
    }
public function specialization()
{
    return $this->belongsTo(specialization::class);
}
}
