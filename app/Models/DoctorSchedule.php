<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorSchedule extends Model
{
    protected $table = 'doctor_schedule';
    protected $guarded = [];


    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

}
