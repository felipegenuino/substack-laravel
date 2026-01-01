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

        User::firstOrCreate(
            ['email' => 'guntaurus@gmail.com'],
            [
                'name' => 'guntaurus',
                'password' => '91142298',
                'email_verified_at' => now(),
            ]
        );
    }
}
