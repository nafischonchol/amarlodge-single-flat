<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class ModelHasRolesSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first(); // Get the user you want to assign roles to
        $role = Role::where('name', 'Owner')->first(); // Get the role you want to assign

        // Attach the role to the user using the morph relation
        if ($user && $role) {
            DB::table('model_has_roles')->insert([
                'role_id' => $role->id,
                'model_type' => get_class($user),
                'model_id' => $user->id,
            ]);
        }
    }
}
