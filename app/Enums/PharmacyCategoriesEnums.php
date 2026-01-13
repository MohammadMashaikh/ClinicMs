<?php
namespace App\Enums;

enum PharmacyCategoriesEnums: string {

    case Antibiotic = 'Antibiotic';
    case Analgesics = 'Analgesics';
    case Antidiabetics = 'Antidiabetics';
    case Antihypertensives = 'Antihypertensives';
    case Antihistamines = 'Antihistamines';
    case NSAIDs = 'NSAIDs';
    case Statins = 'Statins';
    case ProtonPumpInhibitors = 'Proton Pump Inhibitors';
    case Other = 'Other';

}