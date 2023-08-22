<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Nafis Chonchol',
            'email' => 'nafis@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
    }
}
