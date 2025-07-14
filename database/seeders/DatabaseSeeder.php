<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // User::factory(10)->create();
        User::factory()->count(5)->create();    // regular users
        // User::factory()->admin()->create();            // one admin user 

        $this->call([
            OrderSeeder::class,
            ProductSeeder::class,
            OrderProductSeeder::class,
            OrderStatusHistorySeeder::class,
            SuperAdminSeeder::class, // Create a super admin user
        ]);


        
    }
}
