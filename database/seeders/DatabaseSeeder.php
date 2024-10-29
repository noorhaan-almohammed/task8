<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::create(['name' => 'user1', 'email' => 'user1@user' , 'password' => 'password']);

        \App\Models\User::create(['name' => 'user2', 'email' => 'user2@user' , 'password' => 'password']);

        \App\Models\User::create(['name' => 'user3', 'email' => 'user3@user' , 'password' => 'password']);

        \App\Models\User::create(['name' => 'user4', 'email' => 'user4@user' , 'password' => 'password']);
        \App\Models\Status::create(['status' => 'Pending']);
        \App\Models\Status::create(['status' => 'Completed']);
   
    }
}
