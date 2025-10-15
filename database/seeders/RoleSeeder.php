<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['superadmin', 'clinic_admin', 'dentist', 'receptionist', 'patient'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // === ROLE PERMISSIONS ===
        Role::findByName('superadmin')->givePermissionTo(Permission::all());

        Role::findByName('clinic_admin')->givePermissionTo([
            'create appointments', 'edit appointments', 'cancel appointments', 'view appointments', 'approve appointments',
            'add patients', 'edit patients', 'view patients', 'view patient history',
            'add treatment records', 'edit treatment records', 'view treatment records',
            'create transactions', 'edit transactions', 'view transactions', 'generate receipts',
            'manage clinic settings', 'manage services', 'view reports',
        ]);

        Role::findByName('dentist')->givePermissionTo([
            'view appointments', 'create appointments',
            'view patients', 'view patient history',
            'add treatment records', 'edit treatment records', 'view treatment records',
            'view reports',
        ]);

        Role::findByName('receptionist')->givePermissionTo([
            'create appointments', 'edit appointments', 'cancel appointments', 'view appointments',
            'add patients', 'edit patients', 'view patients',
            'create transactions', 'edit transactions', 'view transactions', 'generate receipts',
        ]);

        Role::findByName('patient')->givePermissionTo([
            'create appointments', 'edit appointments', 'cancel appointments', 'view appointments',
            'view patient history', 'view treatment records', 'view transactions',
        ]);

        // Assign Super Admin role
        $superAdminEmail = 'jayveeinfinity@gmail.com';
        $user = User::where('email', $superAdminEmail)->first() ?? User::first();

        if ($user) {
            $user->assignRole('superadmin');
            $this->command->info("✅ Super Admin role assigned to: {$user->email}");
        } else {
            $this->command->warn("⚠️ No user found to assign Super Admin role.");
        }

        $this->command->info('✅ Roles seeded successfully.');
    }
}
