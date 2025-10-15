<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Appointments
            'create appointments', 'edit appointments', 'cancel appointments', 'view appointments', 'approve appointments',

            // Patients
            'add patients', 'edit patients', 'view patients', 'view patient history',

            // Treatments
            'add treatment records', 'edit treatment records', 'view treatment records',

            // Transactions
            'create transactions', 'edit transactions', 'view transactions', 'generate receipts',

            // System / Settings
            'manage users', 'manage clinic settings', 'manage services', 'view reports',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $this->command->info('✅ Permissions seeded successfully.');
    }
}
