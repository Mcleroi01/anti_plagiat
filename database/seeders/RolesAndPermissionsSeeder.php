<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        
        Permission::create(['name' => 'manage credits']);
        Permission::create(['name' => 'view reports']);

        
        $superAdminRole = Role::create(['name' => 'super-admin']);
        $userRole = Role::create(['name' => 'user']);

        $superAdminRole->givePermissionTo(['manage credits', 'view reports']);
    }
}

