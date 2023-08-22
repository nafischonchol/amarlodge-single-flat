<?php

namespace App\Http\Controllers\Api\Rbac;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserAccessRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class UserAccessController extends Controller
{
    public function store(StoreUserAccessRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $user = User::find($data['user_id']);
            // Remove existing roles from the user
            $user->roles()->detach();
            $role = Role::find($data['role_id']);
            $user->assignRole($role);
            if ($role->name == 'Super Admin') {
                $user->save();
            }
            DB::commit();

            return response()->json('Role Assign Successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());

            return response()->json('An error occurred');
        }
    }
}
