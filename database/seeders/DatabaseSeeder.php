<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use Database\Factories\DoctorFactory;
use Database\Factories\PatientFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(AdminSeeder::class);

        // Create 10 doctor with images and assign role 'doctor'
        User::factory()
            ->count(10)
            ->create()
            ->each(function ($user) {
                // Assign role using Spatie method (preferred)
                $user->assignRole('doctor');

                // Download random image for doctor
                $imageContents = Http::get('https://picsum.photos/200')->body();
                $tempPath = sys_get_temp_dir() . '/' . uniqid() . '.jpg';
                file_put_contents($tempPath, $imageContents);

                $user->addMedia($tempPath)
                    ->preservingOriginal()
                    ->toMediaCollection('doctor-image');

                unlink($tempPath);
            });


             // Create 10 patient with images and assign role 'patient'
            User::factory()
            ->count(10)
            ->create()
            ->each(function ($user) {
                // Assign role using Spatie method (preferred)
                $user->assignRole('patient');

                // Download random image for patient
                $imageContents = Http::get('https://picsum.photos/200')->body();
                $tempPath = sys_get_temp_dir() . '/' . uniqid() . '.jpg';
                file_put_contents($tempPath, $imageContents);

                $user->addMedia($tempPath)
                    ->preservingOriginal()
                    ->toMediaCollection('patient-image');

                unlink($tempPath);
            });


            User::factory()
            ->count(10)
            ->create()
            ->each(function ($user) {
                // Assign role using Spatie method (preferred)
                $user->assignRole('receptionist');

                // Download random image for patient
                $imageContents = Http::get('https://picsum.photos/200')->body();
                $tempPath = sys_get_temp_dir() . '/' . uniqid() . '.jpg';
                file_put_contents($tempPath, $imageContents);

                $user->addMedia($tempPath)
                    ->preservingOriginal()
                    ->toMediaCollection('receptionist-image');

                unlink($tempPath);
            });

            User::factory()
            ->count(10)
            ->create()
            ->each(function ($user) {
                // Assign role using Spatie method (preferred)
                $user->assignRole('pharmacy');

                // Download random image for patient
                $imageContents = Http::get('https://picsum.photos/200')->body();
                $tempPath = sys_get_temp_dir() . '/' . uniqid() . '.jpg';
                file_put_contents($tempPath, $imageContents);

                $user->addMedia($tempPath)
                    ->preservingOriginal()
                    ->toMediaCollection('pharmacy-image');

                unlink($tempPath);
            });



            
            $this->call(SpecializationSeeder::class);

            $doctorUsers = User::role('doctor')->get();
            foreach ($doctorUsers as $user) {
                Doctor::factory()->create(['user_id' => $user->id]);
            }

            $patientUsers = User::role('patient')->get();
            foreach ($patientUsers as $user) {
                Patient::factory()->create(['user_id' => $user->id]);
            }


            $this->call(PharmacySeeder::class);

    }
}
