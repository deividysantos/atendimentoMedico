<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Doctor extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $table ='doctors';

    public $timestamps = false;

    protected $fillable = [
        'id', 'name', 'documentMedical_id', 'email', 'password'
    ];

    protected $hidden = ['password'];

    public function attendences()
    {
        return $this->hasMany(Attendence::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
