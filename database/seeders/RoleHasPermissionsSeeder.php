<?php

namespace Database\Seeders;

use App\Models\RoleHasPermission;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleHasPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $role = Role::where('name', 'Owner')->first(); // Get the role you want to assign permissions to
        $permission = Permission::where('module', 'RBAC')->orWhere('display_name', 'RBAC')->get(); // Get the permission you want to assign

        // Attach the permission to the role
        if ($role && $permission) {
            foreach ($permission as $item) {
                RoleHasPermission::create([
                    'permission_id' => $item->id,
                    'role_id' => $role->id,
                ]);
            }
        }
    }
}
