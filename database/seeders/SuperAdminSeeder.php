<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('superadmin123'), // Change to a strong password
            'role' => 'admin',
            'position' => 'SuperAdmin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
