<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'name' => 'Owner',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Tenant',
                'guard_name' => 'web',
            ],
        ]);
    }
}
