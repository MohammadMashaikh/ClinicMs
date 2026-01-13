<?php

namespace App\Models;

use App\Enums\MedicineFormEnums;
use App\Enums\MedicineTypeEnums;
use App\Enums\PharmacyCategoriesEnums;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'medicine_name', 'generic_name', 'category', 'medicine_type', 'description', 'medicine_form',
        'manufacturer', 'supplier', 'manufacturing_date', 'expiry_date', 'batch_number', 'dosage', 'side_effects', 'precautions_warnings',
        'buying_price', 'selling_price', 'quantity', 'reorder_level', 'tax_rate'
    ];

    protected $casts = [
        'manufacturing_date' => 'date',
        'expiry_date' => 'date',
        'category' => PharmacyCategoriesEnums::class,
        'medicine_type' => MedicineTypeEnums::class,
        'medicine_form' => MedicineFormEnums::class,
    ];


}
