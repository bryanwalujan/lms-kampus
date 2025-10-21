<?php
// database/seeders/RolePermissionSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Create Permissions
        $permissions = [
            'manage-users', 'manage-locations', 'manage-classes',
            'upload-materials', 'manage-schedules', 'view-reports',
            'check-attendance', 'access-materials'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create Roles
        $adminRole = Role::create(['name' => 'admin']);
        $dosenRole = Role::create(['name' => 'dosen']);
        $mahasiswaRole = Role::create(['name' => 'mahasiswa']);

        // Assign Permissions
        $adminRole->givePermissionTo(Permission::all());
        $dosenRole->givePermissionTo(['manage-classes', 'upload-materials', 'manage-schedules', 'view-reports']);
        $mahasiswaRole->givePermissionTo(['check-attendance', 'access-materials']);
    }
}