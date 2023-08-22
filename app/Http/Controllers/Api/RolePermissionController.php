<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    public function create(Request $request)
    {
        $this->assignRole();
        // $validatedData = $request->validate([
        //     'role' => 'required|string',
        //     'permission' => 'required|string',
        // ]);

        // $role = Role::create(['name' => $validatedData['role']]);
        // $permission = Permission::create(['name' => $validatedData['permission']]);

        // // Assign the permission to the role
        // $role->givePermissionTo($permission);

        return response()->json(['message' => 'Role and permission created successfully']);
    }

    public function assignRole()
    {
        $user = auth()->user();
        $role = Role::findByName('Admin', 'web');
        $user->assignRole($role);
    }
}
