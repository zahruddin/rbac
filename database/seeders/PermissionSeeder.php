<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // DatabaseSeeder.php atau PermissionSeeder.php
        $permission = Permission::create(['name' => 'manage roles']);
        $adminRole = Role::findByName('admin');
        $adminRole->givePermissionTo($permission);
    }
}
