<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Doctor extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'primary_specialization_id',
        'secondary_specialization_id',
        'license_number',
        'license_expiry_date',
        'qualifications',
        'years_of_experience'
    ];

    protected $casts = [
        'license_expiry_date' => 'date'
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


   
    public function primarySpecialization()
    {
        return $this->belongsTo(Specialization::class, 'primary_specialization_id');
    }

    
    public function secondarySpecialization()
    {
        return $this->belongsTo(Specialization::class, 'secondary_specialization_id');
    }



    public function patients()
    {
        return $this->belongsToMany(Patient::class)
        ->withPivot(['assigned_at', 'reason'])
        ->withTimestamps();
    }



    public function schedules()
    {
        return $this->hasMany(DoctorSchedule::class);
    }
}
