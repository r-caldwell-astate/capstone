<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class contract_statuses extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
        {
        DB::table('contract_statuses')->insert([
[
                'status_name' => 'unsent',
                'description' => 'The contract has been created but not sent.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status_name' => 'pending',
                'description' => 'The contract has been sent and is awaiting a signature.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'status_name' => 'active',
                'description' => 'The contract has been signed and is active.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'status_name' => 'complete',
                'description' => 'The contract has been completed.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
