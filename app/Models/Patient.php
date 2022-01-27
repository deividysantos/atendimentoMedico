<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table = 'patients';

    protected $fillable = [
        'id', 'name', 'document_id', 'phoneNumber', 'email'
    ];

    public function attendences()
    {
        return $this->hasMany(Attendence::class);
    }
}
