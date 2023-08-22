<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(ModelHasRolesSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RoleHasPermissionsSeeder::class);
    }
}
