<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Insert one admin user
        DB::table('users')->insert([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'philrice_id ' => 'PR-002',
            'role_id' => 2, // Assuming '1' is for Admin
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert multiple fake users
        foreach (range(1, 10) as $index) {
            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
                'philrice_id' => 'PR-' . str_pad($index, 3, '0', STR_PAD_LEFT),
                'role_id' => rand(3, 4), // Assign random role (2 to 5)
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
