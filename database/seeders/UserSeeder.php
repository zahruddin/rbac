<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ==== Permissions ====
        $permissions = [
            'manage users',
            'manage dosen',
            'manage mahasiswa',
            'view siakad',
            'input nilai',
            'krs mahasiswa',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // ==== Roles ====
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $dosenRole = Role::firstOrCreate(['name' => 'dosen']);
        $mahasiswaRole = Role::firstOrCreate(['name' => 'mahasiswa']);

        // Assign permission ke role
        $adminRole->givePermissionTo(Permission::all());

        $dosenRole->givePermissionTo([
            'input nilai',
            'view siakad',
        ]);

        $mahasiswaRole->givePermissionTo([
            'krs mahasiswa',
            'view siakad',
        ]);

        // ==== Users ====
        // Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@siakad.test'],
            [
                'name' => 'Admin SIAKAD',
                'password' => Hash::make('password'), // ganti di production
            ]
        );
        $admin->assignRole($adminRole);

        // Dosen
        $dosen = User::firstOrCreate(
            ['email' => 'dosen@siakad.test'],
            [
                'name' => 'Dosen SIAKAD',
                'password' => Hash::make('password'),
            ]
        );
        $dosen->assignRole($dosenRole);

        // Mahasiswa
        $mahasiswa = User::firstOrCreate(
            ['email' => 'mahasiswa@siakad.test'],
            [
                'name' => 'Mahasiswa SIAKAD',
                'password' => Hash::make('password'),
            ]
        );
        $mahasiswa->assignRole($mahasiswaRole);
    }
}
