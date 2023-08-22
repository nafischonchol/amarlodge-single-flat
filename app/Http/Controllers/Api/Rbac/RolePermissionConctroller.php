<?php

namespace App\Http\Controllers\Api\Rbac;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleHasPermissionRequest;
use App\Models\ActivityLog;
use App\Models\RoleHasPermission;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionConctroller extends Controller
{
    public function getPermissions(string $role_id)
    {
        $role = Role::find($role_id);
        $permission_data = Permission::all();
        $permitted_permission = RoleHasPermission::where('role_id', $role_id)->get();
        $permitted_permission_id = collect($permitted_permission)->pluck('permission_id')->toArray();
        $data = [
            'all_permission' => $permission_data,
            'permitted_permission' => $permitted_permission_id,
            'role_info' => $role,
        ];

        return response()->json($data, 200);
    }

    public function getUserPermissions()
    {
        try {
            $user = auth()->user();
            $user->load('roles.permissions');

            $data = $user->roles->pluck('permissions')->flatten()->pluck('name')->unique()->toArray();

            return response()->json($data, 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'message' => $e->getMessage(),
                'success' => false,
                'data' => [],
            ], 400);
        }
    }

    public function store(StoreRoleHasPermissionRequest $request)
    {
        try {
            $check_prev_perm = RoleHasPermission::query()->where('permission_id', $request->permission_id)
                ->where('role_id', $request->role_id)
                ->first();

            if ($check_prev_perm) {
                RoleHasPermission::where('permission_id', $request->permission_id)
                    ->where('role_id', $request->role_id)
                    ->delete();
                $this->storeActivityLog($check_prev_perm);

                return response()->json(null, 200);
            } else {
                $new_permit = new RoleHasPermission;
                $new_permit->permission_id = $request->permission_id;
                $new_permit->role_id = $request->role_id;
                $new_permit->save();

                return response()->json($new_permit, 201);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'success' => false,
                'data' => [],
            ], 400);
        }
    }

    private function storeActivityLog($model)
    {
        $user = auth()->user();
        $data = [
            'user_id' => $user->id,
            'model_id' => $model->role_id.' '.$model->permission_id,
            'model_name' => 'RoleHasPermission',
            'activity_type' => 'Delete',
            'activity' => 'Permission Reboked',
            'extra_info' => \json_encode($model),
        ];

        ActivityLog::create($data);
    }
}
