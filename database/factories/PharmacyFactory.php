<?php

namespace Database\Factories;

use App\Models\Pharmacy;
use App\Enums\MedicineFormEnums;
use App\Enums\MedicineTypeEnums;
use App\Enums\PharmacyCategoriesEnums;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pharmacy>
 */
class PharmacyFactory extends Factory
{
    public function definition()
    {
        $categoryValues = PharmacyCategoriesEnums::cases();
        $typeValues = MedicineTypeEnums::cases();
        $formValues = MedicineFormEnums::cases();

        // Randomly decide if quantity or reorder level is zero
        $quantity = $this->faker->boolean(20) ? 0 : $this->faker->numberBetween(1, 500); // 20% chance of 0
        $reorderLevel = $this->faker->boolean(30) ? 0 : $this->faker->numberBetween(10, 50); // 30% chance of 0

        return [
            'medicine_name' => $this->faker->word . ' ' . $this->faker->word,
            'generic_name' => $this->faker->word,
            'category' => $this->faker->randomElement($categoryValues)->value,
            'medicine_type' => $this->faker->randomElement($typeValues)->value,
            'description' => $this->faker->paragraph,
            'medicine_form' => $this->faker->randomElement($formValues)->value,
            'manufacturer' => $this->faker->company,
            'supplier' => $this->faker->company,
            'manufacturing_date' => $this->faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
            'expiry_date' => $this->faker->dateTimeBetween('now', '+2 years')->format('Y-m-d'),
            'batch_number' => strtoupper($this->faker->bothify('??###')),
            'dosage' => $this->faker->randomElement(['250mg', '500mg', '1g']),
            'side_effects' => $this->faker->sentence,
            'precautions_warnings' => $this->faker->sentence,
            'buying_price' => $this->faker->randomFloat(2, 5, 100),
            'selling_price' => $this->faker->randomFloat(2, 10, 150),
            'quantity' => $quantity,
            'reorder_level' => $reorderLevel,
            'tax_rate' => $this->faker->randomFloat(2, 0, 0.15),
        ];
    }
}
