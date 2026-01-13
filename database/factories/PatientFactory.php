<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Foreign key
            'user_id' => User::inRandomOrder()->value('id'),

            // Basic medical info
            'blood_type' => $this->faker->randomElement(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']),
            'height' => $this->faker->randomFloat(2, 140, 200), // cm
            'weight' => $this->faker->randomFloat(2, 45, 120),  // kg

            // Medical history
            'allergies' => $this->faker->optional()->randomElement(['Penicillin', 'Peanuts', 'Dust', 'None', 'Medications', 'Food']),
            'current_medications' => $this->faker->optional()->randomElement(['Metformin', 'Lisinopril', 'Aspirin']),
            'chronic_diseases' => $this->faker->optional()->randomElement(['Diabetes', 'Hypertension', 'Asthma', 'None']),
            'past_surgeries' => $this->faker->optional()->randomElement(['Appendectomy', 'Knee Replacement', 'Gallbladder Removal']),
            'previous_hospitalizations' => $this->faker->optional()->sentence(3),
            'family_medical_history' => $this->faker->randomElements(
                ['diabetes', 'heart_disease', 'hypertension', 'cancer', 'asthma', 'mental_health_conditions'],
                $this->faker->numberBetween(1, 3)
            ),
            'family_history_notes' => $this->faker->optional()->sentence(8),

            // Insurance details
            'insurance_provider' => $this->faker->company(),
            'policy_number' => strtoupper($this->faker->bothify('POL-####-????')),
            'policy_holder_name' => $this->faker->name(),
            'relationship_to_patient' => $this->faker->randomElement(['self', 'spouse', 'parent', 'child', 'other']),
            'insurance_phone_number' => $this->faker->phoneNumber(),

            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
