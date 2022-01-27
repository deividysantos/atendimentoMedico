<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Doctor extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $table ='doctors';

    public $timestamps = false;

    protected $fillable = [
        'id', 'name', 'documentMedical_id', 'email', 'password'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    public function attendences()
    {
        return $this->hasMany(Attendence::class);
    }
}
