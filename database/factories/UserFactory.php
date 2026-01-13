<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         $first = $this->faker->firstName;
         $last = $this->faker->lastName;

        return [
            'first_name' => $first,
            'last_name' => $last,
            'full_name' => $first . ' ' . $last,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now()->subDays(rand(1, 30)),
            'password' => bcrypt('12341234'),
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            'phone' => $this->faker->phoneNumber,
            'date_of_birth' => $this->faker->date('Y-m-d', '2025-09-29'),
            'address' => $this->faker->address,
            'emergency_contact_name' => $this->faker->name(),
            'emergency_contact_email' => $this->faker->unique()->safeEmail(),
            'emergency_contact_phone' => $this->faker->phoneNumber,
            'emergency_contact_relation' => $this->faker->randomElement([
                'Father', 'Mother', 'Brother', 'Sister', 'Spouse', 'Friend', 'Other'
            ]),
            'created_at' => now()->subDays(rand(1, 60)),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
