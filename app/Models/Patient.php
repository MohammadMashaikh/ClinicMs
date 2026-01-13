<?php

namespace App\Models;

use App\Enums\BloodTypesEnums;
use App\Enums\InsuranceRelationshipToPatient;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Patient extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'blood_type',
        'height',
        'weight',
        'allergies',
        'current_medications',
        'chronic_diseases',
        'past_surgeries',
        'previous_hospitalizations',
        'family_medical_history',
        'family_history_notes',
        'insurance_provider',
        'policy_number',
        'policy_holder_name',
        'relationship_to_patient',
        'insurance_phone_number'
    ];

    protected $casts = [
    'family_medical_history' => 'array',
    'blood_type' => BloodTypesEnums::class,
    'relationship_to_patient' => InsuranceRelationshipToPatient::class
   ];



    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function doctors()
    {
        return $this->belongsToMany(Doctor::class)
        ->withPivot(['assigned_at', 'reason'])
        ->withTimestamps();
    }
}
