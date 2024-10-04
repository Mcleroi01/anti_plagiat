<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        // Vérifiez d'abord si l'utilisateur existe déjà
        $user = User::firstOrCreate([
            'email' => 'carlomusongela@gmail.com', // Utilisez l'email souhaité
        ], [
            'name' => 'Super Admin', // Nom de l'utilisateur
            'password' => bcrypt('12345678'), // Mot de passe de l'utilisateur
        ]);

        // Assigner le rôle de super admin
        $role = Role::firstOrCreate(['name' => 'super admin']);
        $user->assignRole($role);
    }
}
