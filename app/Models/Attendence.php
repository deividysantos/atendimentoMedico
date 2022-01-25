<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendence extends Model
{
    protected $table = 'attendences';

    protected $fillable = [
        'doctor_id',
        'patient_id',
        'entryDate',
        'exitDate',
        'description'
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
