<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    public function index()
    {
        // Récupérer tous les utilisateurs, les rôles et les permissions
        $users = User::with('roles', 'permissions')->get();
        $roles = Role::all();

        return view('admins.roles-permissions', compact('users', 'roles'));
    }

    public function assignRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::findOrFail($request->user_id);
        $user->assignRole($request->role);

        return redirect()->back()->with('success', 'Rôle attribué avec succès.');
    }

    public function revokeRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::findOrFail($request->user_id);
        $user->removeRole($request->role);

        return redirect()->back()->with('success', 'Rôle révoqué avec succès.');
    }
}
