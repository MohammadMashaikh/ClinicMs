<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'start_time',
        'end_time',
        'status',
        'reason_for_visit',
        'date',
        'day_of_week'
    ];


    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'date' => 'date'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }


    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }


    public function prescription()
    {
        return $this->hasOne(Prescription::class);
    }
}
