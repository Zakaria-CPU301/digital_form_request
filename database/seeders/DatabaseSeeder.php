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
            'name' => 'Test User',
            'email' => 'superadmin@sangnila.com',
            'password' => Hash::make('password'),
            'phone_number' => '087732466235',
            'position' => 'Admin',
            'department' => 'Admin',
            'role' => 'admin',
            'overwork_allowance' => 40,
        ]);
    }
}
