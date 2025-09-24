<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@sangnila.com',
            'password' => Hash::make('asd'),
            'phone_number' => '087732466235',
            'position' => 'Admin',
            'department' => 'Admin',
            'role' => 'admin',
            'overwork_allowance' => 40,
        ]);

        User::factory()->create([
            'name' => 'User Employee',
            'email' => 'employee@sangnila.com',
            'password' => Hash::make('asd'),
            'phone_number' => '087732466235',
            'position' => 'Web Programmer',
            'department' => 'IT',
            'role' => 'user',
            'overwork_allowance' => 40,
        ]);
    }
}
