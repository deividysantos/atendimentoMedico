<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Patient extends Authenticatable implements JWTSubject
{
    protected $table = 'patients';

    protected $fillable = [
        'id', 'name', 'document_id', 'phoneNumber', 'email', 'password'
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
