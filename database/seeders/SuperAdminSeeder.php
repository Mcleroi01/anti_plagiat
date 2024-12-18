<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        $user = User::firstOrCreate([
            'email' => 'jcrify@infoSupport.com', 
        ], [
            'name' => 'jcrifysupport', 
            'password' => bcrypt('12345678'),
        ]);

        $role = Role::firstOrCreate(['name' => 'super-admin']);
        $user->assignRole($role);
    }
}
