<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Membuat user default...');
        
        // Pastikan roles sudah ada (dibuat oleh PermissionSeeder)
        $superAdminRole = Role::where('name', 'super-admin')->first();
        $adminRole = Role::where('name', 'admin')->first();
        $userRole = Role::where('name', 'user')->first();

        // Super Admin
        User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
            ]
        )->assignRole($superAdminRole);

        // Admin
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
            ]
        )->assignRole($adminRole);

        // User Biasa
        User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'User Biasa',
                'password' => Hash::make('password'),
            ]
        )->assignRole($userRole);

        $this->command->info('User default berhasil dibuat.');
    }
}
