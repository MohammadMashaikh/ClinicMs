<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $role = Role::firstOrCreate(['name' => 'super-admin']);


        $admin = User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'first_name' => 'Mohammad',
                'last_name' => 'Al-Mashaikh',
                'full_name' => 'Mohammad Al-Mashaikh',
                'phone' => '+962789447358',
                'password' => bcrypt('12341234'),
                'gender' => 'Male',
                'date_of_birth' => '1999-25-02',
                'address' => 'Amman-Jordan',
                'emergency_contact_name' => 'Abed',
                'emergency_contact_relation' => 'Brother',
                'emergency_contact_phone' => '+962795829355'
            ]
        );

        $admin->assignRole($role);
    }
}
