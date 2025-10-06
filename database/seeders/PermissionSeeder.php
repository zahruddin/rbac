<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Selalu reset cache permission di awal
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $this->command->info('Membuat permissions dan roles...');

        // 1. DAFTAR SEMUA PERMISSIONS
        $permissions = [
            // Manajemen Pengguna (CRUD)
            'create-users',
            'read-users',
            'update-users',
            'delete-users',

            // Manajemen Role (CRUD)
            'create-roles',
            'read-roles',
            'update-roles',
            'delete-roles',

            // Manajemen Pengaturan Umum (General Settings)
            'read-general-settings',
            'update-general-settings',
            
            // Tambahkan permission lain di sini (misalnya: 'read-students', 'create-courses')
            'read-general-settings',   // Untuk melihat halaman pengaturan
            'update-general-settings'
        ];

        // 2. Buat permissions jika belum ada
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }
    }
}
