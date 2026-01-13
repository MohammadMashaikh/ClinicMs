<?php

namespace Database\Factories;

use App\Models\Specialization;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Foreign keys
            'user_id' => User::inRandomOrder()->value('id'),
            'primary_specialization_id' => Specialization::inRandomOrder()->value('id'),
            'secondary_specialization_id' => $this->faker->boolean(40)
                ? (Specialization::inRandomOrder()->value('id'))
                : null,

            // License info
            'license_number' => strtoupper($this->faker->bothify('LIC-#####-??')),
            'license_expiry_date' => $this->faker->dateTimeBetween('now', '+5 years'),

            // Education & experience
            'qualifications' => $this->faker->sentence(6), // e.g. "MD in Internal Medicine from Harvard"
            'years_of_experience' => $this->faker->numberBetween(1, 40),

            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
