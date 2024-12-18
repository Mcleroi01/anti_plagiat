<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {

        // Créer les permissions
        $permissions = [
            // Permissions pour le super administrateur
            'superadmin' => [
                'gérer les utilisateurs',
                'gérer les rôles',
                'gérer les paramètres',
                'gérer les crédits',
                'voir les rapports des universités',
            ],

            // Permissions pour l'administrateur
            'admin' => [
                'gérer les crédits de l\'université',
                'gérer les utilisateurs de l\'université',
                'voir les rapports des utilisateurs',
                'voir les statistiques d\'usage',
            ],
            // Permissions pour les utilisateurs
            'user' => [
                'soumettre des documents',
                'avoir les résultats des vérifications'
            ]
        ];

        // Créer toutes les permissions nécessaires
        foreach ($permissions as $role => $rolePermissions) {
            foreach ($rolePermissions as $permission) {
                // Créer la permission si elle n'existe pas déjà
                Permission::firstOrCreate(['name' => $permission]);
            }
        }

        // Créer les rôles
        $superAdminRole = Role::firstOrCreate(['name' => 'superadmin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);


        Permission::create(['name' => 'manage credits']);
        Permission::create(['name' => 'view reports']);


        $superAdminRole = Role::create(['name' => 'super-admin']);
        $userRole = Role::create(['name' => 'user']);

        $superAdminRole->givePermissionTo(['manage credits', 'view reports']);
    }
}
