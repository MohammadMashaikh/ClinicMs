<?php

namespace App\Enums;

enum MedicineFormEnums: string
{
    case Tablet = 'Tablet';
    case Capsule = 'Capsule';
    case Syrup = 'Syrup';
    case Injection = 'Injection';
    case CreamOintment = 'Cream/Ointment';
    case Drops = 'Drops';
    case Other = 'Other';
}
