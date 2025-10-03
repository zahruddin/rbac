<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Selalu reset cache permission di awal untuk memastikan data terbaru
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ==== 1. BUAT PERMISSIONS BARU YANG LEBIH SEDERHANA ====
        $this->command->info('Membuat permissions untuk User & Role Management...');
        
        // PERUBAHAN: Daftar permission disederhanakan menjadi CRUD untuk users dan roles
        $permissions = [
            'create-users',
            'read-users',
            'update-users',
            'delete-users',
            'create-roles',
            'read-roles',
            'update-roles',
            'delete-roles',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }
        $this->command->info('Permissions berhasil dibuat.');


        // ==== 2. BUAT ROLES BARU DAN BERIKAN PERMISSIONS ====
        $this->command->info('Membuat roles dan memberikan permissions...');
        
        // PERUBAHAN: Struktur role diubah menjadi lebih umum
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Super Admin mendapatkan semua permission yang ada
        $superAdminRole->syncPermissions(Permission::all());

        // Admin hanya mendapatkan permission untuk mengelola pengguna
        $adminRole->syncPermissions([
            'create-users',
            'read-users',
            'update-users',
            'delete-users',
        ]);

        // Role 'user' tidak diberikan permission administratif apa pun
        $this->command->info('Roles dan permissions berhasil diatur.');


        // ==== 3. BUAT USER DEFAULT UNTUK SETIAP ROLE BARU ====
        $this->command->info('Membuat user default...');
        
        // PERUBAHAN: User disesuaikan dengan role yang baru
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
