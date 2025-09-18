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

        $this->call([
            ContractFieldSeeder::class,
            ContractStatusSeeder::class,
        ]);

        $user = User::first();
        if (!$user){
            $user = User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@test.com',
                'password' => Hash::make('password'),
            ]);
        }
        
        // Seed some sample contracts for the dashboard (uses first user)
        $this->call([
            ContractSeeder::class,
        ]);
    }
}
