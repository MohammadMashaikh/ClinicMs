<?php

namespace App\Enums;

enum MedicineTypeEnums: string
{
    case OTC = 'Over The Counter (OTC)';
    case Controlled = 'Controlled Substance';
}
