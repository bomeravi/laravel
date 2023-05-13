<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserLocation;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'user_role' => 'admin',
            'gender' => 'male',
        ]);

         \App\Models\User::factory(10)->create()->each(function ($user) {
             $user->location()->save(UserLocation::factory()->make());
         });;


    }
}
