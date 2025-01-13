<?php

namespace App\Models;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'duration'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function doctor_specializations()
    {
    return $this->hasMany(Doctor_specialization::class);

    }
    public function getSpAttribute()
    {
        $dot_sp = $this->doctor_specializations;
        $ret=array();
        foreach($dot_sp as $row)
        { array_push($ret,$row->specialization);
            }
        return $ret;
    }

    public function date_d()
    {
    return $this->hasMany(Date::class,'doctor_id');
    }
    public function date()
    {
    return $this->hasMany(Date::class,'user_id');
    }

    public function date_doc()
    {
    return $this->hasMany(Date::class);
    }
    public function off_day()
    {
    return $this->hasMany(OffDay::class,'user_id');
    }
public function Rate()
    {
    return $this->hasMany(Rating::class,'rate');
    }
}

