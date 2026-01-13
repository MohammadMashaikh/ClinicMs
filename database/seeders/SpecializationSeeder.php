<?php

namespace Database\Seeders;

use App\Enums\SpecializationsEnums;
use App\Models\Specialization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (SpecializationsEnums::cases() as $specialize)
        {
            Specialization::firstOrCreate(['name' => $specialize->value]);
        }
    }
}
