<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Membuat roles dasar...');

        // 3. BUAT ROLES
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);
        
        $this->command->info('Roles berhasil dibuat: Super Admin, Admin, User.');

        // 4. BERIKAN PERMISSIONS KE ROLES

        // Super Admin mendapatkan semua permission yang ada
        $superAdminRole->syncPermissions(Permission::all());
        $this->command->info('Semua permissions diberikan kepada Super Admin.');


        // Admin mendapatkan permission untuk mengelola pengguna, tetapi tidak mengelola roles.
        $adminRole->syncPermissions([
            'read-users',
            'update-users',
            'create-users',
            'delete-users',
        ]);
        $this->command->info('Permissions Admin berhasil diatur.');
        
        // Role 'user' tidak diberikan permission administratif apa pun
        // Jika ada permission non-admin, bisa ditambahkan di sini.
        $userRole->syncPermissions([]);
        $this->command->info('Roles berhasil dibuat: super-admin, admin, user.');

    }
}
