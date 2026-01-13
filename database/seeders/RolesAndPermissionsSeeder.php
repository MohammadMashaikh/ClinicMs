<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permissions
        $permissions = [
            // Doctors
            'view doctors',
            'manage doctors',

            // Patients
            'view patients',
            'manage patients',

            // Schedule
            'view schedule',
            'manage schedule',

            // Appointments
            'view appointments',
            'manage appointments',

            // Roles and Permissions
            'view roles',
            'manage roles',

            // Medical Records
            'view medical records',
            'manage medical records',

            // Laboratory
            'view laboratory',
            'manage laboratory',

            // Pharmacy
            'view pharmacy',
            'manage pharmacy',

            // Invoices / Billing
            'view invoices',
            'manage invoices',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // === ROLES ===

        // 1. Super Admin → All permissions
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        $superAdmin->syncPermissions($permissions);

        // 2. Doctor
        $doctor = Role::firstOrCreate(['name' => 'doctor']);
        $doctor->syncPermissions([
            'view patients',
            'view appointments',
            'manage medical records',
            'view medical records',
            'view laboratory',
            'manage laboratory',
            'view pharmacy', // just to see prescribed meds, not manage stock
        ]);

        // 3. Receptionist
        $receptionist = Role::firstOrCreate(['name' => 'receptionist']);
        $receptionist->syncPermissions([
            'view patients',
            'manage patients',
            'view appointments',
            'manage appointments',
            'view invoices',
            'manage invoices',
        ]);

        // 4. Pharmacy
        $pharmacy = Role::firstOrCreate(['name' => 'pharmacy']);
        $pharmacy->syncPermissions([
            'view pharmacy',
            'manage pharmacy',
        ]);

        // 5. Patient
        $patient = Role::firstOrCreate(['name' => 'patient']);
        $patient->syncPermissions([
            'view doctors',
            'view appointments',
            'view schedule',
            'view medical records',
            'view invoices',
        ]);
    }
}
