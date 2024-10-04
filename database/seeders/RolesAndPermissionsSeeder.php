<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Créer des permissions
        Permission::create(['name' => 'manage credits']);
        Permission::create(['name' => 'view reports']);

        // Créer des rôles
        $superAdminRole = Role::create(['name' => 'super-admin']);
        $userRole = Role::create(['name' => 'user']);

        // Assigner les permissions au super admin
        $superAdminRole->givePermissionTo(['manage credits', 'view reports']);
    }
}

